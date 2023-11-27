// the image we want to convert into a 3d model
src="/Users/fisher/dev/FisherEvans.com/sites/ramblings/src/posts/20231127/src-2tone-grad.png";

// w & h are image size, z depth is whatever you want
resize([800, 500, 10])
surface(file = src, center = true, convexity = 5, invert=true);
