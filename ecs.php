<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\AbstractClassNamePrefixSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\ConstructorNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\InterfaceNameSuffixSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\TraitNameSuffixSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PhpCsFixer\Fixer\Alias\ArrayPushFixer;
use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoPhp4ConstructorFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLinesBeforeNamespaceFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocTagRenameFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocParamOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\HeredocIndentationFixer;
use PhpCsFixerCustomFixers\Fixer\CommentedOutFunctionFixer;
use PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer;
use PhpCsFixerCustomFixers\Fixer\NoSuperfluousConcatenationFixer;
use PhpCsFixerCustomFixers\Fixer\NoTrailingCommaInSinglelineFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessDirnameCallFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocNoSuperfluousParamFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocParamTypeFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocSelfAccessorFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocSingleLineVarFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;
use SlevomatCodingStandard\Sniffs\Commenting\ForbiddenAnnotationsSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use WebimpressCodingStandard\Sniffs\Formatting\HeredocSniff;
use WebimpressCodingStandard\Sniffs\NamingConventions\ExceptionSniff;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->sets([SetList::COMMON, SetList::PSR_12]);
    $ecsConfig->rules(checkerClasses: [
        AbstractClassNamePrefixSniff::class,
        ArrayPushFixer::class,
        ClassReferenceNameCasingFixer::class,
        CombineConsecutiveIssetsFixer::class,
        CombineConsecutiveUnsetsFixer::class,
        CombineNestedDirnameFixer::class,
        CommentedOutFunctionFixer::class,
        ConstructorEmptyBracesFixer::class,
        ConstructorNameSniff::class,
        DirConstantFixer::class,
        EregToPregFixer::class,
        ExceptionSniff::class,
        GeneralPhpdocTagRenameFixer::class,
        HeredocIndentationFixer::class,
        HeredocSniff::class,
        HeredocToNowdocFixer::class,
        IncludeFixer::class,
        InterfaceNameSuffixSniff::class,
        LowercaseStaticReferenceFixer::class,
        ModernizeTypesCastingFixer::class,
        NativeConstantInvocationFixer::class,
        NativeFunctionCasingFixer::class,
        NoAliasFunctionsFixer::class,
        NoBlankLinesAfterPhpdocFixer::class,
        NoEmptyCommentFixer::class,
        NoEmptyPhpdocFixer::class,
        NoEmptyStatementFixer::class,
        NoHomoglyphNamesFixer::class,
        NoMultilineWhitespaceAroundDoubleArrowFixer::class,
        NoPhp4ConstructorFixer::class,
        NoSuperfluousConcatenationFixer::class,
        NoTrailingCommaInSinglelineFixer::class,
        NoUselessCommentFixer::class,
        NoUselessDirnameCallFixer::class,
        PhpdocNoSuperfluousParamFixer::class,
        PhpdocParamOrderFixer::class,
        PhpdocParamTypeFixer::class,
        PhpdocScalarFixer::class,
        PhpdocSelfAccessorFixer::class,
        PhpdocSeparationFixer::class,
        PhpdocSingleLineVarFixer::class,
        PhpdocTypesCommaSpacesFixer::class,
        PsrAutoloadingFixer::class,
        SelfAccessorFixer::class,
        StringableInterfaceFixer::class,
        TernaryToNullCoalescingFixer::class,
        TraitNameSuffixSniff::class,
        ValidClassNameSniff::class,
    ]);

    $ecsConfig->skip([
        NotOperatorWithSuccessorSpaceFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(AlignMultilineCommentFixer::class, [
        'comment_type' => 'phpdocs_only',
    ]); // psr-5
    $ecsConfig->ruleWithConfiguration(BlankLineBeforeStatementFixer::class, [
        'statements' => ['return'],
    ]);
    $ecsConfig->ruleWithConfiguration(BlankLinesBeforeNamespaceFixer::class, [
        'min_line_breaks' => 2,
        'max_line_breaks' => 2,
    ]);
    $ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'method' => 'one',
        ],
    ]);
    $ecsConfig->ruleWithConfiguration(ForbiddenAnnotationsSniff::class, [
        'forbiddenAnnotations' => ['@api', '@author', '@category', '@copyright', '@created', '@license', '@package', '@since', '@subpackage', '@version'],
    ]);
    $ecsConfig->ruleWithConfiguration(IncrementStyleFixer::class, [
        'style' => 'post',
    ]);
    $ecsConfig->ruleWithConfiguration(ListSyntaxFixer::class, [
        'syntax' => 'short',
    ]);
    $ecsConfig->ruleWithConfiguration(NoMixedEchoPrintFixer::class, [
        'use' => 'echo',
    ]);
    $ecsConfig->ruleWithConfiguration(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_mixed' => true,
    ]);
    $ecsConfig->ruleWithConfiguration(PhpdocAddMissingParamAnnotationFixer::class, [
        'only_untyped' => false,
    ]);
    $ecsConfig->ruleWithConfiguration(PhpdocTypesOrderFixer::class, [
        'null_adjustment' => 'always_last',
        'sort_algorithm' => 'none',
    ]);
    $ecsConfig->ruleWithConfiguration(PhpdocOrderFixer::class, [
        'order' => ['param', 'return', 'throws'],
    ]);
    $ecsConfig->ruleWithConfiguration(SingleLineCommentStyleFixer::class, [
        'comment_types' => ['hash'],
    ]);
    $ecsConfig->ruleWithConfiguration(TrailingCommaInMultilineFixer::class, [
        'elements' => ['arrays'],
    ]);

    $ecsConfig->indentation(Option::INDENTATION_SPACES);
    $ecsConfig->lineEnding('\n');
    $ecsConfig->parallel();

    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/ecs.php',
    ]);
};
