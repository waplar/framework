<?php

return [

    'waiter' => [
        'format' => [
            'rules' => [
                'phpdoc_single_line_var_spacing' => true,
                'phpdoc_line_span' => [
                    'const' => 'multi',
                    'method' => 'multi',
                    'property' => 'multi',
                ],
                'phpdoc_add_missing_param_annotation' => [
                    'only_untyped' => true,
                ],
                'phpdoc_trim_consecutive_blank_line_separation' => true,
                'phpdoc_indent' => true,
                'phpdoc_align' => [
                    'align' => 'vertical',
                ],
                'phpdoc_trim' => true,
                'phpdoc_separation' => true,
                'phpdoc_scalar' => true,
                'phpdoc_param_order' => true,
                'phpdoc_types' => [
                    'groups' => [
                        'alias',
                        'meta',
                        'simple',
                    ],
                ],
                'phpdoc_var_annotation_correct_order' => true,
                'phpdoc_to_comment' => true,
                'blank_line_after_namespace' => true,
                'blank_line_after_opening_tag' => true,
                'blank_line_between_import_groups' => true,
                'blank_lines_before_namespace' => true,
                'braces_position' => [
                    'allow_single_line_anonymous_functions' => true,
                ],
                'class_definition' => true,
                'compact_nullable_type_declaration' => true,
                'indentation_type' => true,
                'control_structure_continuation_position' => true,
                'control_structure_braces' => true,
                'constant_case' => true,
                'declare_equal_normalize' => true,
                'elseif' => true,
                'encoding' => true,
                'full_opening_tag' => true,
                'function_declaration' => true,
                'lowercase_cast' => true,
                'lowercase_keywords' => true,
                'lowercase_static_reference' => true,
                'method_argument_space' => true,
                'new_with_parentheses' => true,
                'no_closing_tag' => true,
                'no_extra_blank_lines' => true,
                'no_leading_import_slash' => true,
                'no_multiple_statements_per_line' => true,
                'no_space_around_double_colon' => true,
                'no_spaces_after_function_name' => true,
                'no_trailing_whitespace_in_comment' => true,
                'ordered_class_elements' => true,
                'ordered_imports' => true,
                'return_type_declaration' => true,
                'short_scalar_cast' => true,
                'single_class_element_per_statement' => true,
                'single_line_after_imports' => true,
                'single_space_around_construct' => true,
                'spaces_inside_parentheses' => true,
                'statement_indentation' => true,
                'switch_case_semicolon_to_colon' => true,
                'switch_case_space' => true,
                'visibility_required' => true,
                'clean_namespace' => true,
                'list_syntax' => true,
                'no_whitespace_before_comma_in_array' => true,
                'normalize_index_brace' => true,
                'simple_to_complex_string_variable' => true,
                'ternary_to_null_coalescing' => true,
                'array_indentation' => true,
                'array_syntax' => ['syntax' => 'short'],
                'trailing_comma_in_multiline' => ['elements' => ['arrays']],
                'binary_operator_spaces' => ['default' => 'align_single_space'],
                'no_whitespace_in_blank_line' => true,
                'single_blank_line_at_eof' => true,
                'whitespace_after_comma_in_array' => true,
                'no_trailing_whitespace' => true,
                'trim_array_spaces' => true,
                'blank_line_between_methods' => true,
            ],
        ],
    ],

    'poet' => [
        'config' => [
            'color' => [
                'note' => '192,235,215',
                'warn' => '252,118,7',
                'fail' => '153,51,51',
                'succeed' => '76,152,129',
            ],
        ],

        'styles' => [

            'note' => [
                'status' => [
                    'tag' => [
                        'color' => '255,255,255',
                        'backstage' => '102,0,204',
                        'bold' => true,
                    ], 'message' => [
                        'color' => '255,255,255',
                    ],
                ],
                'message' => [
                    'color' => '102,102,153',
                    'bold' => true,
                ],
            ],

            'warn' => [
                'status' => [
                    'tag' => [
                        'color' => '255,255,255',
                        'backstage' => '155,68,0',
                        'bold' => true,
                    ],
                    'message' => [
                        'color' => '255,255,255',
                    ],
                ],
                'message' => [
                    'color' => '155,68,0',
                    'bold' => true,
                ],
            ],

            'fail' => [
                'status' => [
                    'tag' => [
                        'color' => '255,255,255',
                        'backstage' => '153,51,51',
                        'bold' => true,
                    ],
                    'message' => [
                        'color' => '255,255,255',
                    ],
                ],
                'message' => [
                    'color' => '153,51,51',
                    'bold' => true,
                ],
            ],

            'succeed' => [
                'status' => [
                    'tag' => [
                        'color' => '255,255,255',
                        'backstage' => '0,102,102',
                        'bold' => true,
                    ],
                    'message' => [
                        'color' => '255,255,255',
                    ],
                ],
                'message' => [
                    'color' => '0,102,102',
                    'bold' => true,
                ],
            ],

            'content' => [
                'title' => [
                    'color' => '0,224,158',
                ],
                'border' => [
                    'color' => '214,236,240',
                ],
                'content' => [
                    'color' => '131,127,141',
                ],
            ],
        ],
    ],

];
