variable "domain" { }
variable "redirectTo" { }
variable "hostedZone" { }

resource "aws_s3_bucket" "bucket" {
  bucket = "${var.domain}"
  acl    = "private"
  website {
    redirect_all_requests_to = "${var.redirectTo}"
  }
}

resource "aws_s3_bucket_object" "dontuseObject" {
  bucket  = "${aws_s3_bucket.bucket.id}"
  key     = "don-not-use.txt"
  content = "This bucket is only used for domain redirection"
}

resource "aws_route53_record" "cname" {
  zone_id = "${var.hostedZone}"
  name    = "${var.domain}"
  type    = "CNAME"
  ttl     = "300"
  records = [ "${aws_s3_bucket.bucket.id}.s3-website-us-east-1.amazonaws.com" ]
}