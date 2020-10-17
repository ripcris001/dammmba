<?php
class Loader{
public $Output, $Variables;

public function loadTemp($file, $link, $type) {
		switch(strTolower($type))
		{
			case 'php':
				$template = $link.$file.'.php';
			break;
			case 'html':
				$template = $link.$file.'.html';
			break;
			case 'css':
				$template = $link.$file.'.css';
			break;
		}

        if (!file_exists($template))
        $this->SystemExit('Template not found: ' . $template, __LINE__, __FILE__);

        $data[0][0] = fopen($template, "r");
        $data[0][1] = fread($data[0][0], filesize($template));
        fclose($data[0][0]);
        return $data[0][1];
    }
	
    public function Content() {  
        $this->Output = empty($this->Variables) ? $this->Output : str_replace(array_keys($this->Variables), array_values($this->Variables), $this->Output);
        print $this->Output;
    }
	
	public function SystemExit($text, $line, $file = null) {
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: text/plain');
        print ("$text - " . date("F j, Y, g:i a"));
        print ("\nLocation: $file ($line)");
        exit(1);
    }
}
?>