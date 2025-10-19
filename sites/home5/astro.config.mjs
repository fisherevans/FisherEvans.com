import { defineConfig } from 'astro/config';
import tailwind from "@astrojs/tailwind";
import rehypePrettyCode from 'rehype-pretty-code';
import rehypeSlug from 'rehype-slug';
import mdx from "@astrojs/mdx";

import sitemap from "@astrojs/sitemap";

// https://astro.build/config
export default defineConfig({
  site: 'https://fisherevans.com',
  output: 'static',
  integrations: [tailwind(), mdx({
    syntaxHighlight: false,
    rehypePlugins: [
    /**
     * Adds ids to headings
     */
    rehypeSlug, [
    /**
     * Enhances code blocks with syntax highlighting, line numbers,
     * titles, and allows highlighting specific lines and words
     */

    rehypePrettyCode, {
      theme: 'github-dark'
    }]]
  }), sitemap()]
});
