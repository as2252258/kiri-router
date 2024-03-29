<?php
declare(strict_types=1);

namespace Kiri\Router\Constrict;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{


    /**
     * @var resource|string
     */
    public mixed $content = '';


    /**
     * @var int
     */
    public int $size = 0;


    /**
     * @param mixed $content
     */
    public function __construct(mixed $content = '')
    {
        $this->content = $content;
    }


    /**
     * Reads all data from the stream into a string, from the beginning to end.
     *
     * This method MUST attempt to seek to the beginning of the stream before
     * reading data and read the stream until the end is reached.
     *
     * Warning: This could attempt to load a large amount of data into memory.
     *
     * This method MUST NOT raise an exception in order to conform with PHP's
     * string casting operations.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->content;
    }

    /**
     * Closes the stream and any underlying resources.
     *
     * @return void
     */
    public function close(): void
    {
        // TODO: Implement close() method.
        if (is_resource($this->content)) {
            fclose($this->content);
        } else {
            $this->content = '';
        }
    }

    /**
     * Separates any underlying resources from the stream.
     *
     * After the stream has been detached, the stream is in an unusable state.
     *
     * @return resource|null Underlying PHP stream, if any
     */
    public function detach(): mixed
    {
        // TODO: Implement detach() method.
        return null;
    }

    /**
     * Get the size of the stream if known.
     *
     * @return int|null Returns the size in bytes if known, or null if unknown.
     */
    public function getSize(): ?int
    {
        // TODO: Implement getSize() method.
        return $this->size;
    }

    /**
     * Returns the current position of the file read/write pointer
     *
     * @return int Position of the file pointer
     * @throws
     */
    public function tell(): int
    {
        // TODO: Implement tell() method.
        return 0;
    }

    /**
     * Returns true if the stream is at the end of the stream.
     *
     * @return bool
     */
    public function eof(): bool
    {
        // TODO: Implement eof() method.
        return false;
    }

    /**
     * Returns whether or not the stream is seekable.
     *
     * @return bool
     */
    public function isSeekable(): bool
    {
        // TODO: Implement isSeekable() method.
        return true;
    }

    /**
     * Seek to a position in the stream.
     *
     * @link http://www.php.net/manual/en/function.fseek.php
     * @param int $offset Stream offset
     * @param int $whence Specifies how the cursor position will be calculated
     *     based on the seek offset. Valid values are identical to the built-in
     *     PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
     *     offset bytes SEEK_CUR: Set position to current location plus offset
     *     SEEK_END: Set position to end-of-stream plus offset.
     * @throws
     */
    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        // TODO: Implement seek() method.
        if (is_resource($this->content)) {
            fseek($this->content, $offset, $whence);
        }
    }

    /**
     * Seek to the beginning of the stream.
     *
     * If the stream is not seekable, this method will raise an exception;
     * otherwise, it will perform a seek(0).
     *
     * @throws
     * @link http://www.php.net/manual/en/function.fseek.php
     * @see seek()
     */
    public function rewind(): void
    {
        // TODO: Implement rewind() method.
        $this->seek(0);
    }

    /**
     * Returns whether or not the stream is writable.
     *
     * @return bool
     */
    public function isWritable(): bool
    {
        // TODO: Implement isWritable() method.
        if (is_resource($this->content)) {
            return is_writable($this->content);
        }
        return true;
    }

    /**
     * Write data to the stream.
     *
     * @param string $string The string that is to be written.
     * @return int Returns the number of bytes written to the stream.
     * @throws
     */
    public function write(string $string): int
    {
        // TODO: Implement write() method.
        if (is_resource($this->content)) {
            $this->content = fopen($string, 'wr');
//			$this->size = filesize($string);
        } else {
            $this->content = $string;
//			$this->size = mb_strlen($string);
        }
        return $this->size;
    }

    /**
     * Returns whether or not the stream is readable.
     *
     * @return bool
     */
    public function isReadable(): bool
    {
        // TODO: Implement isReadable() method.
        if (is_resource($this->content)) {
            return is_readable($this->content);
        }
        return true;
    }

    /**
     * Read data from the stream.
     *
     * @param int $length Read up to $length bytes from the object and return
     *     them. Fewer than $length bytes may be returned if underlying stream
     *     call returns fewer bytes.
     * @return string Returns the data read from the stream, or an empty string
     *     if no bytes are available.
     * @throws
     */
    public function read(int $length): string
    {
        // TODO: Implement read() method.
        if (!is_resource($this->content)) {
            return mb_substr($this->content, 0, $length);
        } else {
            return fread($this->content, $length);
        }
    }

    /**
     * Returns the remaining contents in a string
     *
     * @return string
     * @throws
     *     reading.
     */
    public function getContents(): string
    {
        // TODO: Implement getContents() method.
        if (is_resource($this->content)) {
            return fread($this->content, $this->getSize());
        }
        return $this->content;
    }

    /**
     * Get stream metadata as an associative array or retrieve a specific key.
     *
     * The keys returned are identical to the keys returned from PHP's
     * stream_get_meta_data() function.
     *
     * @link http://php.net/manual/en/function.stream-get-meta-data.php
     * @param string|null $key Specific metadata to retrieve.
     * @return array|mixed|null Returns an associative array if no key is
     *     provided. Returns a specific key value if a key is provided and the
     *     value is found, or null if the key is not found.
     */
    public function getMetadata(?string $key = null): mixed
    {
        // TODO: Implement getMetadata() method.
        if (is_resource($this->content)) {
            return stream_get_meta_data($this->content);
        }
        return null;
    }
}
