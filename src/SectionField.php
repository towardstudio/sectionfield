<?php
namespace towardstudio\sectionfield;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\web\View;

use towardstudio\sectionfield\fields\SectionFieldType;
use towardstudio\sectionfield\services\SectionFunctions;

use yii\base\Event;

/**
 * @author    towardstudio
 * @package   SectionField
 * @since     1.0.0
 *
 */
class SectionField extends Plugin
{
    public static ?SectionField $plugin;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

		Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function (RegisterTemplateRootsEvent $e) {
                if (
                    is_dir(
                        $baseDir =
                            $this->getBasePath() .
                            DIRECTORY_SEPARATOR .
                            "templates"
                    )
                ) {
                    $e->roots[$this->id] = $baseDir;
                }
            }
        );

		Event::on(
			Fields::class,
			Fields::EVENT_REGISTER_FIELD_TYPES, [
				$this, 'registerFieldTypes'
			]
		);

		# prettier-ignore
        Event::on(
			CraftVariable::class,
			CraftVariable::EVENT_INIT,
			function (Event $e) {
				/** @var CraftVariable $variable */
				$variable = $e->sender;

				// Attach a service:
				$variable->set(
					"sectionField", SectionFunctions::class
				);
			}
		);

        Craft::info(
            Craft::t("sectionfield", "{name} plugin loaded", [
                "name" => $this->name,
            ]),
            __METHOD__
        );
    }

	/**
	 * Registers the field type provided by this plugin.
	 * @param RegisterComponentTypesEvent $event The event.
	 * @return void
	 */
	public function registerFieldTypes(RegisterComponentTypesEvent $event)
	{
		$event->types[] = SectionFieldType::class;
	}

}
