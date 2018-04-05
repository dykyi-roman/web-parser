<?php

namespace Dykyi\CommandBus;

use Dykyi\CommandBus\{
    Command\Version, Command\Parse, Handler\ParseCommandHandler, Handler\VersionCommandHandler, Handler\WelcomePageCommandHandler, Exception\CommandHandlerNotFound, Command\WelcomePage
};
use SimpleBus\Command\Command;
use SimpleBus\Message\{
    Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext,
    Bus\Middleware\MessageBusSupportingMiddleware,
    CallableResolver\CallableMap,
    CallableResolver\ServiceLocatorAwareCallableResolver,
    Handler\DelegatesToMessageHandlerMiddleware,
    Handler\Resolver\NameBasedMessageHandlerResolver,
    Logging\LoggingMiddleware,
    Name\ClassBasedNameResolver

};
use Psr\Log\{
    LoggerInterface, LogLevel, NullLogger
};
use Dykyi\ValueObjects\CommandInput;

/**
 * Class CommandBus
 * @package Dykyi\Command
 */
final class CommandBus
{
    /** @var MessageBusSupportingMiddleware */
    private $bus;

    /**
     * @return array
     */
    private function getEventSubscribersByEventName(): array
    {
        return [
            Parse::class       => ParseCommandHandler::class,
            Version::class     => VersionCommandHandler::class,
            WelcomePage::class => WelcomePageCommandHandler::class,
        ];
    }

    public function __construct(LoggerInterface $logger = null)
    {
        $this->bus = new MessageBusSupportingMiddleware();
        $this->bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());

        $commandHandlerMap = new CallableMap(
            $this->getEventSubscribersByEventName(),
            new ServiceLocatorAwareCallableResolver($this->setServiceLocatorMethod())
        );
        $commandHandlerResolver = new NameBasedMessageHandlerResolver(
            new ClassBasedNameResolver(), $commandHandlerMap
        );

        // $logger is an instance of LoggerInterface
        $logger = $logger ?: new NullLogger();
        $loggingMiddleware = new LoggingMiddleware($logger, LogLevel::INFO);
        $this->bus->appendMiddleware($loggingMiddleware);

        $this->bus->appendMiddleware(
            new DelegatesToMessageHandlerMiddleware($commandHandlerResolver)
        );
    }

    /**
     * Gets the default command.
     *
     * @return Command
     */
    private function createDefaultCommand(): Command
    {
        return new WelcomePage();
    }

    /**
     * @param CommandInput $input
     * @return Command
     */
    public function createCommandByInput(CommandInput $input): Command
    {
        $class = __NAMESPACE__ . '\\' . 'Command\\' . ucfirst($input->getCommand());
        if (!class_exists($class)) {
            throw CommandHandlerNotFound::forMessage($input->getCommand());
        }

        return new $class(...$input->getOptions());
    }

    /**
     * @param CommandInput $input
     * @return Command
     */
    public function getCommandByInput(CommandInput $input): Command
    {
        return $input->isCommandEmpty()
            ? $this->createDefaultCommand()
            : $this->createCommandByInput($input);
    }

    /**
     * @return callable
     */
    private function setServiceLocatorMethod(): callable
    {
        return function ($serviceId) {
            $handler = new $serviceId();
            //TODO: some logic here
            return $handler;
        };
    }

    /**
     * @param $message
     */
    public function handle($message)// : void
    {
        $this->bus->handle($message);
    }

    /**
     * @param LoggerInterface $logger
     * @return CommandBus
     */
    public static function create(LoggerInterface $logger = null): CommandBus
    {
        return new self($logger);
    }
}