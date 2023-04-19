<?php

namespace Kiri\Router\Aspect;


use Kiri\Di\Interface\InjectProxyInterface;
use PhpParser\ParserFactory;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_CLASS)]
class Aspect implements InjectProxyInterface
{


	/**
	 * @param array|string $aspect
	 */
	public function __construct(readonly public array|string $aspect = [])
	{
	}


	/**
	 * @param string $fileName
	 * @param object $class
	 * @param string $method
	 * @return void
	 */
	public function dispatch(string $fileName, object $class, string $method): void
	{
		// TODO: Implement dispatch() method.
		try {
			$parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
			$ast = $parser->parse(file_get_contents($fileName));

			$cacheFile = storage('proxy_functions.php');
			if (!file_exists($cacheFile)) {
				file_put_contents($cacheFile, '<?php' . PHP_EOL);
			}

			$functionName = str_replace('\\', '_', $class::class) . '_' . $method;
			$code = $this->generateClourse($functionName) . PHP_EOL;

			file_put_contents($cacheFile, $code, FILE_APPEND);
		} catch (\Throwable $throwable) {
			die(throwable($throwable));
		}
	}


	private function generateClourse($functionName): string
	{
		return <<<PHP
if (!function_exists($functionName)) {

	/**
	 * @param mixed \$message
	 * @param string \$method
	 * @throws Exception
	 */
	function $functionName(mixed \$message, string \$method = 'app')
	{
	}
}
PHP;
	}

}
