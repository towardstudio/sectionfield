<?php
namespace towardstudio\sectionfield\fields\conditions;

use Craft;
use craft\base\conditions\BaseMultiSelectConditionRule;
use craft\fields\conditions\FieldConditionRuleInterface;
use craft\fields\conditions\FieldConditionRuleTrait;
use craft\fields\BaseOptionsField;
use craft\fields\data\MultiOptionsFieldData;
use craft\fields\data\OptionData;
use craft\fields\data\SingleOptionFieldData;
use Illuminate\Support\Collection;

/**
 * Options field condition rule.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 4.0.0
 */
class SectionFieldConditionRule extends BaseMultiSelectConditionRule implements FieldConditionRuleInterface
{
    use FieldConditionRuleTrait;

    protected function options(): array
    {
        /** @var BaseOptionsField $field */
        $field = $this->field();

        $allowed = $field->allowedSections;
        $options = [];

        foreach ($allowed as $id) {
            $section = Craft::$app->sections->getSectionById($id);
            if ($section) {
                $options[] = [
                    'value' => $id,
                    'label' => $section['name'],
                ];
            }
        }
        return $options;
    }

    /**
     * @inheritdoc
     */
    protected function elementQueryParam(): ?array
    {
        return $this->paramValue();
    }

    /**
     * @inheritdoc
     */
    protected function matchFieldValue($value): bool
    {
        if ($value instanceof MultiOptionsFieldData) {
            /** @phpstan-ignore-next-line */
            $value = array_map(fn(OptionData $option) => $option->value, (array)$value);
        } elseif ($value instanceof SingleOptionFieldData) {
            $value = $value->value;
        }

        return $this->matchValue($value);
    }
}
