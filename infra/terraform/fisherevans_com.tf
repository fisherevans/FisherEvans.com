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

resource "aws_s3_bucket" "fisherevansBucket" {
  bucket = "fisherevans-com"
  acl    = "private"
  website {
    redirect_all_requests_to = "www.fisherevans.com"
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


# Hosted Content Entries

# module "hosted-root" { # S3 website rules will redirect this distro to 'hosted-www'
#   source = "components/hosted_subdomain"
  
#   hostedZone = "${aws_route53_zone.fisherevansHostedZone.zone_id}"  
#   domain = "${var.rootDomain}"
#   domainPrefix = ""
#   sslCertArn = "${var.sslCertArn}"
  
#   bucket = "${aws_s3_bucket.fisherevansBucket.id}"
#   path = ""
# }

module "hosted-www" {
  source = "components/hosted_subdomain"
  
  hostedZone = "${aws_route53_zone.fisherevansHostedZone.zone_id}"  
  domain = "${var.rootDomain}"
  domainPrefix = "www."
  sslCertArn = "${var.sslCertArn}"
  
  bucket = "${aws_s3_bucket.fisherevansBucket.id}"
  path = "/hosted-content/www"
}

module "hosted-resume" {
  source = "components/hosted_subdomain"
  
  hostedZone = "${aws_route53_zone.fisherevansHostedZone.zone_id}"  
  domain = "${var.rootDomain}"
  domainPrefix = "resume."
  sslCertArn = "${var.sslCertArn}"
  
  bucket = "${aws_s3_bucket.fisherevansBucket.id}"
  path = "/hosted-content/resume"
}
