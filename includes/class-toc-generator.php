<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class TOC_Generator {

    /**
     * The main method that takes HTML content and returns it with a TOC.
     *
     * @param string $html The input HTML content.
     * @return string The modified HTML content.
     */
    public function generate(string $html): string {
        if ( empty($html) ) {
            return $html;
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        $headings = $xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');

        if ($headings->length < 2) { // Don't generate TOC for less than 2 headings
            return $html;
        }

        $toc_list_items = [];
        $current_level = 0;
        $open_tags = 0;

        foreach ($headings as $heading) {
            $level = (int) substr($heading->tagName, 1);
            $text = trim($heading->nodeValue);
            
            if (empty($text)) continue;

            $anchor = $this->sanitize_anchor($text);
            if (!$heading->hasAttribute('id')) {
                $heading->setAttribute('id', $anchor);
            }

            if ($level > $current_level) {
                $toc_list_items[] = '<ul>';
                $open_tags++;
            } elseif ($level < $current_level) {
                $toc_list_items[] = str_repeat('</li></ul>', $current_level - $level);
                $open_tags -= ($current_level - $level);
            }

            if ($level === $current_level && !empty($toc_list_items)) {
                $toc_list_items[] = '</li>';
            }
            
            $current_level = $level;
            $toc_list_items[] = "<li><a href='#{$anchor}'>{$text}</a>";
        }

        // Close any remaining open tags.
        if ($open_tags > 0) {
            $toc_list_items[] = str_repeat('</li></ul>', $open_tags);
        }

        // Assemble the final TOC HTML.
        $toc_html = "<div class='mindmade_toc_list'><h2 class='is-open'>Table of Contents</h2><ul>" . implode('', $toc_list_items) . "</ul></div>";

        // First, save the HTML with the new IDs added to the headings.
        $content_with_ids = $dom->saveHTML();
        
        // Then, simply prepend the TOC HTML string to the content.
        // This is a much more robust method and avoids the DocumentFragment warning.
        return $toc_html . $content_with_ids;
    }

    /**
     * Sanitizes a string to be used as an HTML anchor ID.
     *
     * @param string $string The input string.
     * @return string The sanitized string.
     */
    private function sanitize_anchor(string $string): string {
        // Using WordPress's built-in function is the best practice.
        return sanitize_title($string);
    }
}