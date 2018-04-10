
variable "region"     { default = "us-east-1" }
variable "rootDomain" { default = "fisherevans.com" }
variable "sslCertArn" { default = "arn:aws:acm:us-east-1:658675223305:certificate/93b48056-2f0e-43ce-a490-d700cbbea7a6" }

provider "aws" {
  region = "${var.region}"
}

resource "aws_route53_zone" "fisherevansHostedZone" {
   name = "${var.rootDomain}."
}

resource "aws_s3_bucket" "fisherevansBucket" {
  bucket = "fisherevans-com"
  acl    = "private"
  website {
    index_document = "index.html"
    #error_document = "hosted-content/error.html"
  }
}

data "aws_iam_policy_document" "hostedContentReadPolicy" {
  statement {
    sid = "AllowPublicRead"
    principals = {
     type = "*"
     identifiers = ["*"]
    }
    actions = [
      "s3:GetObject"
    ]
    resources = [
      "arn:aws:s3:::${aws_s3_bucket.fisherevansBucket.id}/hosted-content/*"
    ]
  }
}

resource "aws_s3_bucket_policy" "publicReadPolicy" {
  bucket = "${aws_s3_bucket.fisherevansBucket.id}"
  policy = "${data.aws_iam_policy_document.hostedContentReadPolicy.json}"
}

module "hosted-www" {
  source = "components/hosted_subdomain"
  
  hostedZone = "${aws_route53_zone.fisherevansHostedZone.zone_id}"  
  domain = "${var.rootDomain}"
  subdomain = "www"
  sslCertArn = "${var.sslCertArn}"
  
  bucket = "${aws_s3_bucket.fisherevansBucket.id}"
  keyPrefix = "hosted-content/www"
}

