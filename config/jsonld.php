<?php

return [
    /**
     * Enable strict validation mode.
     * When true, missing required fields will throw a ValidationException.
     */
    'strict' => true,

    /**
     * Pretty print JSON output.
     * When true, JSON will be formatted with indentation.
     */
    'pretty_print' => false,

    /**
     * HTML escape mode for script tag content.
     * Options: 'none', 'json_encode', 'htmlspecialchars'
     */
    'escape_mode' => 'json_encode',

    /**
     * Default JSON encode flags.
     */
    'json_flags' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
];
