<?php

namespace Streply\StreplyLaravel;

use Illuminate\Support\Facades\Auth;
use Streply\Exceptions\InvalidDsnException;
use Streply\Exceptions\InvalidUserException;
use Streply\Streply;
use function Streply\Log;

class StreplyClient
{
    /**
     * @var string
     */
    protected string $dsn;

    /**
     * @var array
     */
    protected array $options;

    /**
     * @param string $dsn
     * @param array $options
     */
    public function __construct(string $dsn, array $options)
    {
        $this->dsn = $dsn;
        $this->options = $options;
    }

    /**
     * @throws InvalidDsnException
     */
    public function initialize(): void
    {
        Streply::Initialize($this->dsn, $this->options);
    }

	/**
	 * @return void
	 */
	public function flush(): void
	{
		Streply::Flush();
	}

    /**
     * @throws InvalidUserException
     */
	public function user(): void
    {
        if(Auth::check()) {
            Streply::User(Auth::id(), Auth::user()->name ?? null);
        }
    }

    /**
     * @param string $name
     * @param array $parameters
     */
    public function log(string $name, array $parameters = []): void
    {
        Log($name, $parameters);
    }

	/**
	 * @param string|null $route
	 * @return void
	 */
	public function setRoute(?string $route): void
	{
		Streply::parameterBag()->set('performance.route', $route);
	}
}
