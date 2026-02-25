<?php

namespace App\Services;

class ThemeGenerator
{
    /**
     * Generate Tailwind CSS variables based on a primary hex color.
     * Takes the hex (assumed to be the 500 weight) and generates 50-950.
     */
    public static function generateCssVariables(string $hex): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) !== 6) {
            // Fallback to default indigo if invalid
            $hex = '6366f1';
        }

        // Convert hex to rgb
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $palette = [
            50 => self::tint($r, $g, $b, 0.95),
            100 => self::tint($r, $g, $b, 0.9),
            200 => self::tint($r, $g, $b, 0.75),
            300 => self::tint($r, $g, $b, 0.6),
            400 => self::tint($r, $g, $b, 0.3),
            500 => "#$hex",            // Base color
            600 => self::shade($r, $g, $b, 0.1),
            700 => self::shade($r, $g, $b, 0.25),
            800 => self::shade($r, $g, $b, 0.4),
            900 => self::shade($r, $g, $b, 0.5),
            950 => self::shade($r, $g, $b, 0.65),
        ];

        $css = ":root {\n";
        foreach ($palette as $weight => $color) {
            $css .= "    --color-brand-{$weight}: {$color};\n";
        }
        $css .= "}";

        return $css;
    }

    /**
     * Mix color with white
     */
    private static function tint($r, $g, $b, $percentage): string
    {
        $r2 = round($r + (255 - $r) * $percentage);
        $g2 = round($g + (255 - $g) * $percentage);
        $b2 = round($b + (255 - $b) * $percentage);

        return sprintf("#%02x%02x%02x", $r2, $g2, $b2);
    }

    /**
     * Mix color with black
     */
    private static function shade($r, $g, $b, $percentage): string
    {
        $r2 = round($r * (1 - $percentage));
        $g2 = round($g * (1 - $percentage));
        $b2 = round($b * (1 - $percentage));

        return sprintf("#%02x%02x%02x", $r2, $g2, $b2);
    }
}
