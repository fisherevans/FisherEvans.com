################
## VARIABLES
################

variable "region"     { default = "us-east-1" }
variable "rootDomain" { default = "fisherevans.com" }
variable "sslCertArn" { default = "arn:aws:acm:us-east-1:658675223305:certificate/f268ac93-863e-4b21-8d95-a3fab2ac96f9" }



################
## PROVIDERS
################

provider "aws" {
  region = "${var.region}"
}



################
## RESOURCES
################

# Global DNS Entries

resource "aws_route53_zone" "fisherevansHostedZone" {
   name = "${var.rootDomain}."
}


# Hosted Content Bucket

resource "aws_s3_bucket" "contentBucket" {
  bucket = "fisherevans-com-content"
  acl    = "private"
}

data "aws_iam_policy_document" "contentReadPolicy" {
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
      "arn:aws:s3:::${aws_s3_bucket.contentBucket.id}/hosted-content/*"
    ]
  }
}

resource "aws_s3_bucket_policy" "contentPolicyAttachment" {
  bucket = "${aws_s3_bucket.contentBucket.id}"
  policy = "${data.aws_iam_policy_document.contentReadPolicy.json}"
}


# Hosted Content Entries

module "hosted-personal" {
  source = "components/hosted_subdomain"
  
  hostedZone = "${aws_route53_zone.fisherevansHostedZone.zone_id}"  
  domain = "${var.rootDomain}"
  domainPrefix = ""
  sslCertArn = "${var.sslCertArn}"
  
  bucket = "${aws_s3_bucket.contentBucket.id}"
  path = "/hosted-content/personal"
}

module "hosted-resume" {
  source = "components/hosted_subdomain"
  
  hostedZone = "${aws_route53_zone.fisherevansHostedZone.zone_id}"  
  domain = "${var.rootDomain}"
  domainPrefix = "resume."
  sslCertArn = "${var.sslCertArn}"
  
  bucket = "${aws_s3_bucket.contentBucket.id}"
  path = "/hosted-content/resume"
}


# Root Domain Redirect

resource "aws_route53_record" "redirect-www" {
  zone_id = "${aws_route53_zone.fisherevansHostedZone.zone_id}"
  name    = "www.${var.rootDomain}"
  type    = "CNAME"
  ttl     = "300"
  records = [ "cap960m8.easyredirengine.com" ]
}

