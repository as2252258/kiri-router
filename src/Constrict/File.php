<?php

namespace Kiri\Router\Constrict;

use Exception;
use Kiri;

class File
{


    private string $name;
    private string $tmp_name;
    private int    $error;
    private string $type;
    private int    $size;
    private int    $limit  = 1024000;
    private int    $offset = 0;


    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->name     = $array['name'];
        $this->tmp_name = $array['tmp_name'];
        $this->error    = $array['error'];
        $this->type     = $array['type'];
        $this->size     = $array['size'];
    }

    const array  errorInfo = [
        0 => 'UPLOAD_ERR_OK.',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        3 => 'The uploaded file was only partially uploaded.',
        4 => 'No file was uploaded.',
        6 => 'Missing a temporary folder.',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.'
    ];

    /**
     * @param string $path
     * @return bool
     * @throws
     */
    public function saveTo(string $path): bool
    {
        if ($this->hasError()) {
            throw new Exception($this->getErrorInfo());
        }

        @move_uploaded_file($this->tmp_name, $path);
        if (!file_exists($path)) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     * @throws
     */
    public function rename(): string
    {
        if (!empty($this->newName)) return $this->newName;
        if (!file_exists($this->getTmpPath())) {
            throw new Exception('(' . $this->name . ')Failed to open stream: No such file or directory');
        }

        $hash = md5_file($this->getTmpPath());

        $later = '.' . exif_imagetype($this->getTmpPath());

        $match = '/(\w{12})(\w{5})(\w{9})(\w{6})/';
        $tmp   = preg_replace($match, '$1-$2-$3-$4', $hash);

        return $this->name = strtoupper($tmp) . $later;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }


    /**
     * @return string
     * @throws
     */
    public function getContent(): string
    {
        $open    = fopen($this->getTmpPath(), 'r');
        $content = '';
        while ($file = fread($open, $this->limit)) {
            $content .= $file;
            fseek($open, $this->offset);
            if ($this->offset >= $this->getSize()) {
                break;
            }
            $this->offset += $this->limit;
        }
        fclose($open);
        $this->offset = 0;
        return $content;
    }


    /**
     * @return string
     */
    public function getTmpPath(): string
    {
        return $this->tmp_name;
    }

    /**
     * @return bool
     *
     * check file have error
     */
    public function hasError(): bool
    {
        return $this->error !== 0;
    }

    /**
     * @return mixed
     *
     * get upload error info
     */
    public function getErrorInfo(): mixed
    {
        if (!isset(self::errorInfo[$this->error])) {
            return 'Unknown upload error.';
        }
        return self::errorInfo[$this->error];
    }

}