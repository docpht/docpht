<?php
/**
 * This file is part of the ParsedownCheckbox package.
 *
 * (c) Simon Leblanc <contact@leblanc-simon.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ParsedownCheckbox extends ParsedownExtra
{
    const VERSION = '0.0.4';

    public function __construct()
    {
        parent::__construct();

        array_unshift($this->BlockTypes['['], 'Checkbox');
    }

    protected function blockCheckbox($line)
    {
        $text = trim($line['text']);
        $begin_line = substr($text, 0, 4);
        if ('[ ] ' === $begin_line) {
            return [
                'handler' => 'checkboxUnchecked',
                'text' => substr(trim($text), 4),
            ];
        }

        if ('[x] ' === $begin_line) {
            return [
                'handler' => 'checkboxChecked',
                'text' => substr(trim($text), 4),
            ];
        }
    }

    protected function blockListComplete(array $block)
    {
        foreach ($block['element']['text'] as &$li_element) {
            foreach ($li_element['text'] as $text) {
                $begin_line = substr(trim($text), 0, 4);
                if ('[ ] ' === $begin_line) {
                    $li_element['attributes'] = ['class' => 'parsedown-task-list parsedown-task-list-open'];
                } elseif ('[x] ' === $begin_line) {
                    $li_element['attributes'] = ['class' => 'parsedown-task-list parsedown-task-list-close'];
                }
            }
        }

        return $block;
    }

    protected function blockCheckboxContinue(array $block)
    {
    }

    protected function blockCheckboxComplete(array $block)
    {
        $block['markup'] = $this->{$block['handler']}($block['text']);

        return $block;
    }

    protected function checkboxUnchecked($text)
    {
        if ($this->markupEscaped || $this->safeMode) {
            $text = self::escape($text);
        }

        return '<input type="checkbox" disabled /> '.$text;
    }

    protected function checkboxChecked($text)
    {
        if ($this->markupEscaped || $this->safeMode) {
            $text = self::escape($text);
        }

        return '<input type="checkbox" checked disabled /> '.$text;
    }
}
