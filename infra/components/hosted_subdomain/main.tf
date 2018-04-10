variable "hostedZone" { }
variable "domain" { }
variable "subdomain" { }
variable "sslCertArn" { }
variable "bucket" { }
variable "keyPrefix" { }

resource "aws_cloudfront_distribution" "distribution" {
  
  origin {
    origin_id = "${var.subdomain}.${var.domain}-origin"
    domain_name = "${var.bucket}.s3.amazonaws.com"
    origin_path = "/${var.keyPrefix}"
  }
  
  enabled = true
  aliases = [ "${var.subdomain}.${var.domain}" ]
  
  default_cache_behavior {
    allowed_methods = [ "GET", "HEAD" ]
    cached_methods = [ "GET", "HEAD" ]
    target_origin_id = "${var.subdomain}.${var.domain}-origin"
    forwarded_values {
      query_string = false
      cookies { forward = "none" }
    }
    viewer_protocol_policy = "allow-all"
    min_ttl = 0
    default_ttl = 30
    max_ttl = 86400
  }

  price_class = "PriceClass_All"
  restrictions {
    geo_restriction { restriction_type = "none" }
  }
  
  viewer_certificate {
    acm_certificate_arn = "${var.sslCertArn}"
    ssl_support_method = "sni-only"
    minimum_protocol_version = "TLSv1"
  }
}

resource "aws_route53_record" "dnsRecord" {
  name = "${var.subdomain}.${var.domain}"
  zone_id = "${var.hostedZone}"
  type = "A"
  alias {
    name = "${aws_cloudfront_distribution.distribution.domain_name}"
    zone_id = "${aws_cloudfront_distribution.distribution.hosted_zone_id}"
    evaluate_target_health = false
  }
}