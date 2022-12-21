variable "domain" {}
variable "redirectTo" {}
variable "sslCertArn" {}
variable "hostedZone" {}

resource "aws_iam_role" "redirectFnRole" {
  name = "${var.domain}-redirect-fn-role"
  assume_role_policy = <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Action": "sts:AssumeRole",
      "Principal": {
        "Service": "lambda.amazonaws.com"
      },
      "Effect": "Allow",
      "Sid": ""
    }
  ]
}
EOF
}

resource "aws_lambda_function" "redirectFn" {
  function_name = "${replace(var.domain, ".", "-")}-redirect-fn"
  filename = "components/redirected-domain/redirect-fn.zip"
  source_code_hash = "${base64sha256(filebase64("components/redirected-domain/redirect-fn.zip"))}"
  handler = "redirect-fn.handler"
  runtime = "nodejs16.x"
  role = "${aws_iam_role.redirectFnRole.arn}"
  environment {
    variables = {
      redirectBase = "${var.redirectTo}"
    }
  }
}

resource "aws_api_gateway_rest_api" "redirectApi" {
  name        = "${var.domain}-rediect"
  description = "Redirect traffic from ${var.domain} to ${var.redirectTo}"
}

resource "aws_api_gateway_method" "rootMethod" {
  rest_api_id   = "${aws_api_gateway_rest_api.redirectApi.id}"
  resource_id   = "${aws_api_gateway_rest_api.redirectApi.root_resource_id}"
  http_method   = "ANY"
  authorization = "NONE"
}

resource "aws_api_gateway_integration" "rootLambda" {
  rest_api_id = "${aws_api_gateway_rest_api.redirectApi.id}"
  resource_id = "${aws_api_gateway_method.rootMethod.resource_id}"
  http_method = "${aws_api_gateway_method.rootMethod.http_method}"
  integration_http_method = "POST"
  type                    = "AWS_PROXY"
  uri                     = "${aws_lambda_function.redirectFn.invoke_arn}"
}

resource "aws_api_gateway_resource" "proxyResource" {
  rest_api_id = "${aws_api_gateway_rest_api.redirectApi.id}"
  parent_id   = "${aws_api_gateway_rest_api.redirectApi.root_resource_id}"
  path_part   = "{proxy+}"
}

resource "aws_api_gateway_method" "proxyMethod" {
  rest_api_id   = "${aws_api_gateway_rest_api.redirectApi.id}"
  resource_id   = "${aws_api_gateway_resource.proxyResource.id}"
  http_method   = "ANY"
  authorization = "NONE"
}

resource "aws_api_gateway_integration" "proxyLambda" {
  rest_api_id = "${aws_api_gateway_rest_api.redirectApi.id}"
  resource_id = "${aws_api_gateway_method.proxyMethod.resource_id}"
  http_method = "${aws_api_gateway_method.proxyMethod.http_method}"
  integration_http_method = "POST"
  type                    = "AWS_PROXY"
  uri                     = "${aws_lambda_function.redirectFn.invoke_arn}"
}

resource "aws_api_gateway_deployment" "deployment" {
  depends_on = [
    "aws_api_gateway_integration.rootLambda",
    "aws_api_gateway_integration.proxyLambda",
  ]
  rest_api_id = "${aws_api_gateway_rest_api.redirectApi.id}"
  stage_name  = "redirect"
}

resource "aws_lambda_permission" "apigwLambdaPermission" {
  statement_id  = "AllowAPIGatewayInvoke"
  action        = "lambda:InvokeFunction"
  function_name = "${aws_lambda_function.redirectFn.arn}"
  principal     = "apigateway.amazonaws.com"
  source_arn = "${aws_api_gateway_deployment.deployment.execution_arn}/*/*"
}

resource "aws_api_gateway_domain_name" "customDomain" {
  domain_name = "${var.domain}"

  certificate_arn = "${var.sslCertArn}"
}

resource "aws_api_gateway_base_path_mapping" "customDomainMapping" {
  api_id      = "${aws_api_gateway_rest_api.redirectApi.id}"
  stage_name  = "${aws_api_gateway_deployment.deployment.stage_name}"
  domain_name = "${aws_api_gateway_domain_name.customDomain.domain_name}"
}

resource "aws_route53_record" "dnsRecord" {
  zone_id = "${var.hostedZone}"
  name = "${aws_api_gateway_domain_name.customDomain.domain_name}"
  type = "A"
  alias {
    name                   = "${aws_api_gateway_domain_name.customDomain.cloudfront_domain_name}"
    zone_id                = "${aws_api_gateway_domain_name.customDomain.cloudfront_zone_id}"
    evaluate_target_health = false
  }
}
