<?php declare(strict_types=1);

if (@!include __DIR__ . '/../vendor/autoload.php') {
	die('Install packages using `composer install`');
}

use Tracy\Dumper;
use Tracy\Debugger;
use Nette\Forms\Form;
use Nette\Utils\Html;

Debugger::enable();

function bootstrap4(Form $form): void
{
	    $renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = null;
		$renderer->wrappers['pair']['container'] = 'div class="form-group"';
		$renderer->wrappers['pair']['.error'] = 'has-danger';
		$renderer->wrappers['control']['container'] = 'div class=col';
		$renderer->wrappers['label']['container'] = 'div class="col col-form-label font-weight-bold"';
		$renderer->wrappers['control']['description'] = 'span class=form-text';
		$renderer->wrappers['control']['errorcontainer'] = 'span class=form-error';

		foreach ($form->getControls() as $control) {
			$type = $control->getOption('type');
			if ($type === 'button') {
				$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-secondary btn-block' : 'btn btn-primary');
				$usedPrimary = true;

			} elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
				$control->getControlPrototype()->addClass('form-control selectpicker');

			} elseif ($type === 'file') {
				$control->getControlPrototype()->addClass('form-control-file');

			} elseif (in_array($type, ['checkbox', 'radio'], true)) {
				if ($control instanceof \Nette\Forms\Controls\Checkbox) {
					$control->getLabelPrototype()->addClass('form-check-label');
				} else {
					$control->getItemLabelPrototype()->addClass('form-check-label');
				}
				$control->getControlPrototype()->addClass('form-check-input');
				$control->getSeparatorPrototype()->setName('div')->addClass('form-check');
			}
		}
}


$form = new Form;
$form->onRender[] = 'bootstrap4';

$form->addGroup('Installing');

$translations = json_decode(file_get_contents(realpath('src/translations/code-translations.json')), true);
asort($translations);
$form->addSelect('translations','Language', $translations)
        ->setPrompt('Select an option')
        ->setHtmlAttribute('data-live-search','true')
        ->setRequired('Required');

$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

$form->addSelect('timezone', 'Time zone', array_combine($tzlist,$tzlist))
        ->setPrompt('Select an option')
        ->setHtmlAttribute('data-live-search','true')
        ->setRequired('Required');

$date = [
    'd-m-Y H:i' => date('d-m-Y H:i'),
    'Y-m-d H:i' => date('Y-m-d H:i')
];
$form->addRadioList('dataformat', 'Data format', $date)->setRequired('Required');

$actualPath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
if (substr($actualPath, -1) != '/') {
    $actualPath = $actualPath.'/';
}
$form->addText('baseurl','Base url')
    ->setOption('description', Html::el('small')->setAttribute('class','text-muted')->setText('Make sure the URL is correct'))
    ->setValue($actualPath)
    ->setRequired('Required');

$form->addGroup('Administrator account');
$form->addPassword('password', 'Enter a password')
    ->setRequired('Required');

$form->addGroup();
$form->addSubmit('submit', 'Install');

if ($form->isSuccess()) {
    $values = $form->getValues();
    
    if (isset($values)) {
        $data = "<?php\n\n"
            .'define("TITLE", "DocPHT");'."\n"
            .'define("ADMIN", "admin");'."\n"
            .'define("DS", DIRECTORY_SEPARATOR);'."\n"
            .'define("BASE_PATH", __DIR__ . DS);'."\n"
            .'define("SUBTITLE", "Programming");'."\n"
            .'define("DOWNLOAD", "https://github.com/kenlog");'."\n"
            .'define("GITHUB", "https://github.com/kenlog");'."\n"
            .'define("LANGUAGE","'.$values['translations'].'");'."\n"
            .'define("TIMEZONE","'.$values['timezone'].'");'."\n"
            .'define("DATAFORMAT","'.$values['dataformat'].'");'."\n"
            .'define("BASE_URL","'.$values['baseurl'].'");'."\n"
        ;
        $file = 'src/config/config.php';
        mkdir(pathinfo($file, PATHINFO_DIRNAME), 0755, true);
        file_put_contents($file, $data);
        header('Location:'.$values['baseurl']);
        exit;
    } else {
        echo 'Error!';
    }
}

?>

<?php include 'install/partial/head.php'; ?>
<div class="col-sm-6 offset-sm-3 mb-4">
    <div class="card">
        <div class="card-body">
            <?= $form; ?>
        </div>
    </div>
</div>
<?php include 'install/partial/footer.php'; ?>