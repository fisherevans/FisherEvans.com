variable "hostedZone" { }
variable "domain" { }
variable "domainPrefix" { }
variable "sslCertArn" { }
variable "bucket" { }
variable "path" { }
variable "error404Path" { default = "/index.html" }

resource "aws_cloudfront_distribution" "distribution" {
  
  enabled = true
  aliases = [ "${var.domainPrefix}${var.domain}" ]
  default_root_object = "index.html"
  price_class = "PriceClass_All"
  
  origin {
    origin_id = "${var.domainPrefix}${var.domain}-origin"
    domain_name = "${var.bucket}.s3.amazonaws.com"
    origin_path = var.path
  }
  
  default_cache_behavior {
    allowed_methods = [ "GET", "HEAD" ]
    cached_methods = [ "GET", "HEAD" ]
    target_origin_id = "${var.domainPrefix}${var.domain}-origin"
    forwarded_values {
      query_string = false
      cookies { forward = "none" }
    }
    viewer_protocol_policy = "redirect-to-https"
    min_ttl = 0
    default_ttl = 30
    max_ttl = 86400
  }

  restrictions {
    geo_restriction { restriction_type = "none" }
  }
  
  viewer_certificate {
    acm_certificate_arn = var.sslCertArn
    ssl_support_method = "sni-only"
    minimum_protocol_version = "TLSv1.1_2016"
  }
  
  custom_error_response {
    error_code = 403
    response_code = 404
    response_page_path = var.error404Path
  }
}

resource "aws_route53_record" "dnsRecord" {
  name = "${var.domainPrefix}${var.domain}"
  zone_id = var.hostedZone
  type = "A"
  alias {
    name = aws_cloudfront_distribution.distribution.domain_name
    zone_id = aws_cloudfront_distribution.distribution.hosted_zone_id
    evaluate_target_health = false
  }
}
