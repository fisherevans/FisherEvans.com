
variable "region" { default = "us-east-1" }
variable "rootDomain" { default = "fisherevans.com" }

provider "aws" {
  region = "${var.region}"
}

resource "aws_s3_bucket" "fisherevansBucket" {
  bucket = "fisherevans-com"
  acl    = "private"
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
