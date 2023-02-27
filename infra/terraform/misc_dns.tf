# Various DNS entries unrelated to websites

resource "aws_route53_record" "googleMXRecords" {
  zone_id = aws_route53_zone.fisherevansHostedZone.zone_id
  name    = var.rootDomain
  type    = "MX"
  records = [
    "10 aspmx.l.google.com",
    "20 alt1.aspmx.l.google.com",
    "20 alt2.aspmx.l.google.com",
    "30 aspmx2.googlemail.com",
    "30 aspmx3.googlemail.com",  
  ]
  ttl = "3600"
}

resource "aws_route53_record" "homeARecord" {
  zone_id = aws_route53_zone.fisherevansHostedZone.zone_id
  name    = "home.${var.rootDomain}"
  type    = "A"
  ttl     = "300"
  records = [ "98.229.1.130" ]
}
