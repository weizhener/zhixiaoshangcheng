<?php

/**
 * JSON 公用类库
 */

class JSON
{
    var $at   = 0;
    var $ch   = '';
    var $text = '';

    //note 默认type=0返回obj,type=1返回array
    function decode($text, $type = 0)
    {
        if(empty($text))
        {
            return '';
        }
        elseif(!is_string($text))
        {
            return false;
        }

        $this->at   = 0;
        $this->ch   = '';
        $this->text = strtr(stripslashes($text), array(
            "\r"   => '', "\n"   => '', "\t"   => '', "\b"   => '',
            "\x00" => '', "\x01" => '', "\x02" => '', "\x03" => '',
            "\x04" => '', "\x05" => '', "\x06" => '', "\x07" => '',
            "\x08" => '', "\x0b" => '', "\x0c" => '', "\x0e" => '',
            "\x0f" => '', "\x10" => '', "\x11" => '', "\x12" => '',
            "\x13" => '', "\x14" => '', "\x15" => '', "\x16" => '',
            "\x17" => '', "\x18" => '', "\x19" => '', "\x1a" => '',
            "\x1b" => '', "\x1c" => '', "\x1d" => '', "\x1e" => '',
            "\x1f" => ''
            ));
        $this->next();
        $return = $this->val();
        $result = empty($type) ? $return : get_object_vars_deep($return);
        return $result;
    }

    /**
     * triggers a PHP_ERROR
     *
     * @access   private
     * @param    string    $m    error message
     *
     * @return   void
     */
    function error($m)
    {
        trigger_error($m.' at offset '.$this->at.': '.$this->text, E_USER_ERROR);
    }

    /**
     * returns the next character of a JSON string
     *
     * @access  private
     *
     * @return  string
     */
    function next()
    {
        $this->ch = !isset($this->text{$this->at}) ? '' : $this->text{$this->at};
        $this->at++;
        return $this->ch;
    }

    /**
     * handles strings
     *
     * @access  private
     *
     * @return  void
     */
    function str()
    {
        $i = '';
        $s = '';
        $t = '';
        $u = '';

        if($this->ch == '"')
        {
            while ($this->next() !== null)
            {
                if($this->ch == '"')
                {
                    $this->next();
                    return $s;
                }
                elseif($this->ch == '\\')
                {
                    switch ($this->next())
                    {
                        case 'b':
                            $s .= '\b';
                        break;

                        case 'f':
                            $s .= '\f';
                        break;

                        case 'n':
                            $s .= '\n';
                        break;

                        case 'r':
                            $s .= '\r';
                        break;

                        case 't':
                            $s .= '\t';
                        break;

                        case 'u':
                            $u = 0;

                            for($i = 0; $i < 4; $i++)
                            {
                                $t = (integer) sprintf('%01c', hexdec($this->next()));

                                if(!is_numeric($t))
                                {
                                    break 2;
                                }
                                $u = $u * 16 + $t;
                            }

                            $s .= chr($u);
                        break;

                        default:
                            $s .= $this->ch;
                    }
                }
                else
                {
                    $s .= $this->ch;
                }
            }
        }

        $this->error('Bad string');
    }

    /**
     * handless arrays
     *
     * @access  private
     *
     * @return  void
     */
    function arr()
    {
        $a = array();

        if($this->ch == '[')
        {
            $this->next();

            if($this->ch == ']')
            {
                $this->next();
                return $a;
            }

            while (isset($this->ch))
            {
                array_push($a, $this->val());

                if($this->ch == ']')
                {
                    $this->next();
                    return $a;
                }
                elseif ($this->ch != ',')
                {
                    break;
                }

                $this->next();
            }

            $this->error('Bad array');
        }
    }

    /**
     * handles objects
     *
     * @access  public
     *
     * @return  void
     */
    function obj()
    {
        $k = '';
        $o = new StdClass();

        if($this->ch == '{')
        {
            $this->next();

            if($this->ch == '}')
            {
                $this->next();
                return $o;
            }

            while ($this->ch)
            {
                $k = $this->str();

                if($this->ch != ':')
                {
                    break;
                }

                $this->next();
                $o->$k = $this->val();

                if($this->ch == '}')
                {
                    $this->next();
                    return $o;
                }
                elseif ($this->ch != ',')
                {
                    break;
                }

                $this->next();
            }
        }

        $this->error('Bad object');
    }

    /**
     * handles objects
     *
     * @access  public
     *
     * @return  void
     */
     function assoc()
     {
        $k = '';
        $a = array();

        if($this->ch == '<')
        {
            $this->next();

            if($this->ch == '>')
            {
                $this->next();
                return $a;
            }

            while ($this->ch)
            {
                $k = $this->str();

                if($this->ch != ':')
                {
                    break;
                }

                $this->next();
                $a[$k] = $this->val();

                if($this->ch == '>')
                {
                    $this->next();
                    return $a;
                }
                elseif ($this->ch != ',')
                {
                    break;
                }

                $this->next();
            }
        }

        $this->error('Bad associative array');
    }

    /**
     * handles numbers
     *
     * @access  private
     *
     * @return  void
     */
    function num()
    {
        $n = '';
        $v = '';

        if($this->ch == '-')
        {
            $n = '-';
            $this->next();
        }

        while ($this->ch >= '0' && $this->ch <= '9')
        {
            $n .= $this->ch;
            $this->next();
        }

        if($this->ch == '.')
        {
            $n .= '.';

            while ($this->next() && $this->ch >= '0' && $this->ch <= '9')
            {
                $n .= $this->ch;
            }
        }

        if($this->ch == 'e' || $this->ch == 'E')
        {
            $n .= 'e';
            $this->next();

            if($this->ch == '-' || $this->ch == '+')
            {
                $n .= $this->ch;
                $this->next();
            }

            while ($this->ch >= '0' && $this->ch <= '9')
            {
                $n .= $this->ch;
                $this->next();
            }
        }

        $v += $n;

        if(!is_numeric($v))
        {
            $this->error('Bad number');
        }
        else
        {
            return $v;
        }
    }

    /**
     * handles words
     *
     * @access  private
     *
     * @return  mixed
     */
    function word()
    {
        switch ($this->ch)
        {
            case 't':
                if($this->next() == 'r' && $this->next() == 'u' && $this->next() == 'e')
                {
                    $this->next();
                    return true;
                }
                break;
            case 'f':
                if($this->next() == 'a' && $this->next() == 'l' && $this->next() == 's' && $this->next() == 'e')
                {
                    $this->next();
                    return false;
                }
                break;

            case 'n':
                if($this->next() == 'u' && $this->next() == 'l' && $this->next() == 'l')
                {
                    $this->next();
                    return null;
                }
                break;
        }
        $this->error('Syntax error');
    }

    /**
     * generic value handler
     *
     * @access  private
     *
     * @return  mixed
     */
    function val() {
        switch ($this->ch)
        {
            case '{': return $this->obj();
            case '[': return $this->arr();
            case '<': return $this->assoc();
            case '"': return $this->str();
            case '-': return $this->num();
            default : return ($this->ch >= '0' && $this->ch <= '9') ? $this->num() : $this->word();
        }
    }
}

?>