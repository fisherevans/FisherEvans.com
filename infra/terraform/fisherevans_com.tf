################
## VARIABLES
################

variable "region"     { default = "us-east-1" }
variable "rootDomain" { default = "fisherevans.com" }


################
## PROVIDERS
################

provider "aws" {
  region = var.region
}


################
## RESOURCES
################

# Global DNS Entries

resource "aws_route53_zone" "fisherevansHostedZone" {
   name = "${var.rootDomain}."
}


# HTTP Certificate

resource "aws_acm_certificate" "httpsCert" {
  domain_name       = var.rootDomain
  validation_method = "DNS"
  subject_alternative_names = [ "*.${var.rootDomain}" ]
}

resource "aws_route53_record" "httpsValidationRecord" {
  for_each = {
    for dvo in aws_acm_certificate.httpsCert.domain_validation_options : dvo.domain_name => {
      name   = dvo.resource_record_name
      record = dvo.resource_record_value
      type   = dvo.resource_record_type
    }
  }

  allow_overwrite = true
  name            = each.value.name
  records         = [each.value.record]
  ttl             = 60
  type            = each.value.type
  zone_id         = aws_route53_zone.fisherevansHostedZone.zone_id
}

resource "aws_acm_certificate_validation" "httpsValidation" {
  certificate_arn         = aws_acm_certificate.httpsCert.arn
  validation_record_fqdns = [for record in aws_route53_record.httpsValidationRecord : record.fqdn]
}


# Hosted Content Bucket

resource "aws_s3_bucket" "contentBucket" {
  bucket = "fisherevans-com-content"
  acl    = "private"
}

data "aws_iam_policy_document" "contentReadPolicy" {
  statement {
    sid = "AllowPublicRead"
    principals {
     type = "*"
     identifiers = ["*"]
    }
    actions = [
      "s3:GetObject"
    ]
    resources = [
      "arn:aws:s3:::${aws_s3_bucket.contentBucket.id}/hosted-content/*"
    ]
  }
}

resource "aws_s3_bucket_policy" "contentPolicyAttachment" {
  bucket = aws_s3_bucket.contentBucket.id
  policy = data.aws_iam_policy_document.contentReadPolicy.json
}


# Hosted Content Entries

module "hosted-personal" {
  source = "./components/hosted_subdomain"
  
  hostedZone = aws_route53_zone.fisherevansHostedZone.zone_id
  domain = var.rootDomain
  domainPrefix = ""
  sslCertArn = aws_acm_certificate.httpsCert.arn
  
  bucket = aws_s3_bucket.contentBucket.id
  path = "/hosted-content/personal"
  error404Path = "/404.html"
}

module "hosted-resume" {
  source = "./components/hosted_subdomain"
  
  hostedZone = aws_route53_zone.fisherevansHostedZone.zone_id
  domain = var.rootDomain
  domainPrefix = "resume."
  sslCertArn = aws_acm_certificate.httpsCert.arn
  
  bucket = aws_s3_bucket.contentBucket.id
  path = "/hosted-content/resume"
}

module "hosted-metamorph" {
  source = "./components/hosted_subdomain"
  
  hostedZone = aws_route53_zone.fisherevansHostedZone.zone_id
  domain = var.rootDomain
  domainPrefix = "metamorph."
  sslCertArn = aws_acm_certificate.httpsCert.arn
  
  bucket = aws_s3_bucket.contentBucket.id
  path = "/hosted-content/metamorph"
}


# www. Redirect

module "redirect-www" {
  source = "./components/redirected-domain"

  domain = "www.${var.rootDomain}"
  redirectTo = "https://${var.rootDomain}"
  hostedZone = aws_route53_zone.fisherevansHostedZone.zone_id
  sslCertArn = aws_acm_certificate.httpsCert.arn
}

