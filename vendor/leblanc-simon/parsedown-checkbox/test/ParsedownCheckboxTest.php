<?php

class ParsedownCheckboxTest extends PHPUnit_Framework_TestCase
{
    const MARKDOWN = <<<EOF
Test

- [ ] test 1
- [] test 2
- [x] test 3
    - [ ] test 4 <a></a>
    - [x] test 5
- [test](https://markdown.org) 6
- [x](https://markdown.org) test 7
EOF;

    const HTML = <<<EOF
<p>Test</p>
<ul>
<li class="parsedown-task-list parsedown-task-list-open">
<input type="checkbox" disabled /> test 1
</li>
<li>[] test 2</li>
<li class="parsedown-task-list parsedown-task-list-close">
<input type="checkbox" checked disabled /> test 3
<ul>
<li class="parsedown-task-list parsedown-task-list-open">
<input type="checkbox" disabled /> test 4 <a></a>
</li>
<li class="parsedown-task-list parsedown-task-list-close">
<input type="checkbox" checked disabled /> test 5
</li>
</ul>
</li>
<li><a href="https://markdown.org">test</a> 6</li>
<li><a href="https://markdown.org">x</a> test 7</li>
</ul>
EOF;

    const HTML_SANITIZED = <<<EOF
<p>Test</p>
<ul>
<li class="parsedown-task-list parsedown-task-list-open">
<input type="checkbox" disabled /> test 1
</li>
<li>[] test 2</li>
<li class="parsedown-task-list parsedown-task-list-close">
<input type="checkbox" checked disabled /> test 3
<ul>
<li class="parsedown-task-list parsedown-task-list-open">
<input type="checkbox" disabled /> test 4 &lt;a&gt;&lt;/a&gt;
</li>
<li class="parsedown-task-list parsedown-task-list-close">
<input type="checkbox" checked disabled /> test 5
</li>
</ul>
</li>
<li><a href="https://markdown.org">test</a> 6</li>
<li><a href="https://markdown.org">x</a> test 7</li>
</ul>
EOF;

    public function testCheckbox()
    {
        $parsedown = new ParsedownCheckbox();
        $this->assertEquals(self::HTML, $parsedown->text(self::MARKDOWN));
    }

    public function testCheckboxWithSafeMode()
    {
        $parsedown = new ParsedownCheckbox();
        $parsedown->setSafeMode(true);
        $this->assertEquals(self::HTML_SANITIZED, $parsedown->text(self::MARKDOWN));
    }

    public function testCheckboxWithMarkupEscaped()
    {
        $parsedown = new ParsedownCheckbox();
        $parsedown->setSafeMode(true);
        $this->assertEquals(self::HTML_SANITIZED, $parsedown->text(self::MARKDOWN));
    }
}
