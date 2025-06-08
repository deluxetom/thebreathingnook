<?php

declare(strict_types=1);

/*
 * Distribution and reproduction are prohibited.
 *
 * @package   www.bang.com
 * @copyright SCTR Services LLC 2017
 * @license   No License (Proprietary)
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$header = <<<'EOF'
    Distribution and reproduction are prohibited.

    @package   thebreathingnook
    @copyright Deluxetom 2025
    @license   No License (Proprietary)
    EOF;

$rules = [
    '@PHP84Migration'            => true,
    '@Symfony'                   => true,
    '@Symfony:risky'             => true,
    '@DoctrineAnnotation'        => true,
    '@PHPUnit100Migration:risky' => true,
    'yoda_style'                 => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    'concat_space'               => ['spacing' => 'none'],
    'phpdoc_to_comment'          => [
        'ignored_tags' => ['var', 'phpstan-var', 'psalm-var', 'psalm-suppress', 'noinspection'],
    ],
    'single_line_comment_style' => ['comment_types' => ['asterisk', 'hash']],
    'array_syntax'              => ['syntax' => 'short'],
    'ordered_imports'           => [
        'imports_order' => ['const', 'class', 'function'],
    ],
    'blank_line_before_statement' => [
        'statements' => ['if', 'break', 'continue', 'declare', 'return', 'throw', 'try', 'switch'],
    ],
    'trailing_comma_in_multiline' => ['elements' => ['arrays', 'match', 'parameters']],
    'binary_operator_spaces'      => [
        'default'   => 'single_space',
        'operators' => [
            '='  => 'align_single_space_minimal',
            '=>' => 'align_single_space_minimal',
            '.=' => 'align_single_space_minimal',
            '-=' => 'align_single_space_minimal',
            '+=' => 'align_single_space_minimal',
            '*=' => 'align_single_space_minimal',
            '%=' => 'align_single_space_minimal',
            '|'  => 'no_space',
        ],
    ],
    'general_phpdoc_annotation_remove' => [
        'annotations' => ['author', 'since', 'package', 'subpackage'],
    ],
    'header_comment'                      => ['header' => $header],
    'increment_style'                     => ['style' => 'post'],
    'no_superfluous_elseif'               => true,
    'no_useless_else'                     => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_no_empty_return'              => true,
    'single_line_empty_body'              => false,
    'explicit_string_variable'            => true,
    'native_function_invocation'          => false,
    'native_constant_invocation'          => false,
    'is_null'                             => false,
];

$finder = Finder::create()
    ->in([
        __DIR__.'/src',
    ])
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true);

$config = new Config();
$config
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setUsingCache(true);

return $config;
