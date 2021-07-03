<?php
class Files{

/*
Exemplo de uso na rota welcome
Route::get('/', function () {
    return Files::dirSize('/backup/www');
//    return view('welcome');
});
*/
    // Retorna o conteúdo completo de um arquivo
    public static function readFile($file){
        $content = '';
        if(file_exists($file)){
            $lines = file($file);
            foreach ($lines as $line_num => $line) {
                $content .= "{$line_num} - " . htmlspecialchars($line) . "<br>\n";
            }
            return $content;
        }else{
            echo 'File not fount';
        }
    }

    // Retorna o conteúdo de uma linha de um arquivo
    public static function readFileLine($file, $lineNumber){
        $lines = file($file);
        foreach($lines as $key=>$line){
            if($key == $lineNumber){
                return $line;
            }
        }
    }

    public static function fileCountLines($file){
        $line_count = count (file ($file));
        return $line_count;
    }

    // Ler de forma inversa (Do final para o começo) um arquivo, linha a linha
    public static function readInverseFile($file){
        $f_contents = array_reverse (file ($file));
        return $f_contents;
    }

    // Checar se arquivo pode ser lido pelo Apache
    public static function isFileReadable($file){
        if (is_readable($file)) {
            return true;
        }else{
	        return false;
        }
    }

    // Checar se arquivo tem permissão de escrita para o Apache
    public static function isFileWritable($file){
        if(is_writable($file)){
            return true;
        }else{
            return false;
        }
    }

    // source = /backup/www/testes, destination = /backup/www/teste.zip
    public static function Zip($source, $destination)
    {
        if (!file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true){
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

          foreach ($files as $file){
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true){					
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }else if (is_file($file) === true){
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
	    // Crédito: http://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
    }

    // Copiar uma pasta com todos os arquivos e subpastas recursivamente
    public static function folderCopy( $source, $target ) {
        if(is_dir($target)){
            print 'Target folder exists';
            exit;
        }
        if ( is_dir( $source ) ) {
            mkdir( $target );
            $d = dir( $source );
            while ( FALSE !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }
                $Entry = $source . '/' . $entry; 
                if ( is_dir( $Entry ) ) {
                    self::folderCopy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }
            $d->close();
        }else {
            copy( $source, $target );
        }
    }

    // Excluir um arquivo. Entrar com path full (/var/www/html/src.php) ou relativo ('../src.php')
    public static function fileDelete($file){
        $result = unlink($file);
        return $result;
    }

    // Criar um novo diretório. Entrar com path full (/var/www/html/dir1) ou relativo ('../dir1')
    public static function makeDir($dir){
        $result = mkdir($dir);
        return $result;
    }

    // retornar o nome do arquivo atual
    public static function currentFile(){
        $result = basename(__FILE__);
        return $result;
    }

    // retornar o nome do diretório atual
    public static function currentDir(){
        $result = basename(__DIR__);
        return $result;
    }

	// Retorna o tamanho de um diretório recursivamente em Bytes, KB, MB ou GB dependendo do tamanho
	public static function dirSize(string $directory) {
		$size = 0;
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
		    $size+=$file->getSize();
		}
		if($size<1024){
			$size=$size." Bytes";
		}elseif(($size<1048576)&&($size>1023)){
			$size=round($size/1024, 1)." KB";
		}elseif(($size<1073741824)&&($size>1048575)){
			$size=round($size/1048576, 1)." MB";
		}else{
			$size=round($size/1073741824, 1)." GB";
		}

		return $size;
		// https://stackoverflow.com/questions/478121/how-to-get-directory-size-in-php
	} 
	// print dirSize('/var/www/html/joomla');
   
}

