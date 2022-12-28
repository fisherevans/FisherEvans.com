# `fisherevans.com`

This repo contains the infrastructure for all websites and static content hosted under [`fisherevans.com`](https://fisherevans.com).

### Static Content

Some small sites are maintained directly in this repository under the `sites` directory.

### Submodules

Some sites are generated from git submodules (i.e. `metamorph`). The submodules are fetched and built; their production build files are then copied to the `sites` directory. These files are `.gitignore`'d.

This process is automated by running `./refresh-submodules.sh`

### Testing Locally

You can `./serve-local.sh <site directory>` to serve static content locally. This is helpful for testing changes during developement.

### Deploying Content

You can `sync` static content from your local environment to the shared S3 bucket by running `./force-deploy.sh <site>`.

### Managing Infrastructure

The DNS, CloudFront, and other AWS resources used to actually host and deliver the content is managed by terraform within `infra/terraform`.
