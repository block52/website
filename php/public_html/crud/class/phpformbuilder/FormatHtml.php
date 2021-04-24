<?php
namespace phpformbuilder;

class FormatHtml
{
    private $input = '';
    private $output = '';
    private $tabs = 0;
    private $in_tag = false;
    private $in_comment = false;
    private $in_content = false;
    private $inline_tag = false;
    private $input_index = 0;

    public function html($input)
    {
        $this->input = $input;
        $this->output = '';

        $starting_index = 0;

        if (preg_match('/<\!doctype/i', $this->input)) {
            $starting_index = strpos($this->input, '>') + 1;
            $this->output .= substr($this->input, 0, $starting_index);
        }

        for ($this->input_index = $starting_index; $this->input_index < strlen($this->input); $this->input_index++) {
            if ($this->in_comment) {
                $this->parseComment();
            } elseif ($this->in_tag) {
                $this->parseInnerTag();
            } elseif ($this->inline_tag) {
                $this->parseInnerInlineTag();
            } else {
                if (preg_match('/[\r\n\t]/', $this->input[$this->input_index])) {
                    continue;
                } elseif ($this->input[$this->input_index] == '<') {
                    if (! $this->isInlineTag()) {
                        $this->in_content = false;
                    }
                    $this->parseTag();
                } elseif (! $this->in_content) {
                    if (! $this->inline_tag) {
                        $this->output .= "\n" . str_repeat("\t", $this->tabs);
                    }
                    $this->in_content = true;
                }
                $this->output .= $this->input[$this->input_index];
            }
        }

        return $this->output;
    }

    private function parseComment()
    {
        if ($this->isEndComment()) {
            $this->in_comment = false;
            $this->output .= '-->';
            $this->input_index += 3;
        } else {
            $this->output .= $this->input[$this->input_index];
        }
    }

    private function parseInnerTag()
    {
        if ($this->input[$this->input_index] == '>') {
            $this->in_tag = false;
            $this->output .= '>';
        } else {
            $this->output .= $this->input[$this->input_index];
        }
    }

    private function parseInnerInlineTag()
    {
        if ($this->input[$this->input_index] == '>') {
            $this->inline_tag = false;
            $this->decrementTabs();
            $this->output .= '>';
        } else {
            $this->output .= $this->input[$this->input_index];
        }
    }

    private function parseTag()
    {
        if ($this->isComment()) {
            $this->output .= "\n" . str_repeat("\t", $this->tabs);
            $this->in_comment = true;
        } elseif ($this->isEndTag()) {
            $this->in_tag = true;
            $this->inline_tag = false;
            $this->decrementTabs();
            if (! $this->isInlineTag() and ! $this->isTagEmpty()) {
                $this->output .= "\n" . str_repeat("\t", $this->tabs);
            }
        } else {
            $this->in_tag = true;
            if (! $this->in_content and ! $this->inline_tag) {
                $this->output .= "\n" . str_repeat("\t", $this->tabs);
            }
            if (! $this->isClosedTag()) {
                $this->tabs++;
            }
            if ($this->isInlineTag()) {
                $this->inline_tag = true;
            }
        }
    }

    private function isEndTag()
    {
        for ($input_index = $this->input_index; $input_index < strlen($this->input); $input_index++) {
            if ($this->input[$input_index] == '<' and $this->input[$input_index + 1] == '/') {
                return true;
            } elseif ($this->input[$input_index] == '<' and $this->input[$input_index + 1] == '!') {
                return true;
            } elseif ($this->input[$input_index] == '>') {
                return false;
            }
        }

        return false;
    }

    private function decrementTabs()
    {
        $this->tabs--;
        if ($this->tabs < 0) {
            $this->tabs = 0;
        }
    }

    private function isComment()
    {
        if ($this->input[$this->input_index] == '<'
        and $this->input[$this->input_index + 1] == '!'
        and $this->input[$this->input_index + 2] == '-'
        and $this->input[$this->input_index + 3] == '-') {
            return true;
        } else {
            return false;
        }
    }

    private function isEndComment()
    {
        if ($this->input[$this->input_index] == '-'
        and $this->input[$this->input_index + 1] == '-'
        and $this->input[$this->input_index + 2] == '>') {
            return true;
        } else {
            return false;
        }
    }

    private function isTagEmpty()
    {
        $current_tag = $this->getCurrentTag($this->input_index + 2);
        $in_tag = false;

        for ($input_index = $this->input_index - 1; $input_index >= 0; $input_index--) {
            if (! $in_tag) {
                if ($this->input[$input_index] == '>') {
                    $in_tag = true;
                } elseif (! preg_match('/\s/', $this->input[$input_index])) {
                    return false;
                }
            } else {
                if ($this->input[$input_index] == '<') {
                    if ($current_tag == $this->getCurrentTag($input_index + 1)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    private function getCurrentTag($input_index)
    {
        $current_tag = '';

        for ($input_index; $input_index < strlen($this->input); $input_index++) {
            if ($this->input[$input_index] == '<') {
                continue;
            } elseif ($this->input[$input_index] == '>' or preg_match('/\s/', $this->input[$input_index])) {
                return $current_tag;
            } else {
                $current_tag .= $this->input[$input_index];
            }
        }

        return $current_tag;
    }

    private function isClosedTag()
    {
        $closed_tags = array(
            'meta', 'link', 'img', 'hr', 'br', 'input',
        );

        $current_tag = '';

        for ($input_index = $this->input_index; $input_index < strlen($this->input); $input_index++) {
            if ($this->input[$input_index] == '<') {
                continue;
            } elseif (preg_match('/\s/', $this->input[$input_index])) {
                break;
            } else {
                $current_tag .= $this->input[$input_index];
            }
        }

        if (in_array($current_tag, $closed_tags)) {
            return true;
        } else {
            return false;
        }
    }

    private function isInlineTag()
    {
        $inline_tags = array(
            'title', 'a', 'span', 'abbr', 'acronym', 'b', 'basefont', 'bdo', 'big', 'cite', 'code', 'dfn', 'em', 'font', 'i', 'kbd', 'q', 's', 'samp', 'small', 'strike', 'strong', 'sub', 'sup', 'textarea', 'tt', 'u', 'var', 'del', 'pre',
        );

        $current_tag = '';

        for ($input_index = $this->input_index; $input_index < strlen($this->input); $input_index++) {
            if ($this->input[$input_index] == '<' or $this->input[$input_index] == '/') {
                continue;
            } elseif (preg_match('/\s/', $this->input[$input_index]) or $this->input[$input_index] == '>') {
                break;
            } else {
                $current_tag .= $this->input[$input_index];
            }
        }

        if (in_array($current_tag, $inline_tags)) {
            return true;
        } else {
            return false;
        }
    }
}
