<?php
namespace SFramework;


use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SORM\DataSource;
use SORM\Drivers\Mysql;

class Application implements ApplicationInterface
{

    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;

    /** @var Router */
    protected $router;

    /**
     * Application constructor.
     *
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->router = new Router('App\\Controllers', $this->request->getUri());
        FrameSet::i()
            ->addFrame('front', new Frame(), true)
            ->addFrame('back', new Frame());
    }

    /**
     * Get application response
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get application request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * General settings
     *
     * @param array $settings
     * @return $this
     */
    public function settings(array $settings = [])
    {
        $general = $settings['general'];
        FrameSet::f()
            ->setTitle($general['title'])
            ->setFavicon($general['favicon']['path'], $general['favicon']['isPNG']);

        $mysql = $settings['datasource']['mysql'];
        DataSource::i()
            ->addDriver(
                'mysql',
                new Mysql(
                    $mysql['host'],
                    $mysql['db'],
                    $mysql['charset'],
                    $mysql['user'],
                    $mysql['password']
                )
            )
            ->getCurrentDriver()
            ->connect();

        return $this;
    }

    /**
     * Run application
     *
     * @return Response
     */
    public function run()
    {
        $controllerActionCallable = $this->router->route();
        $controllerActionCallable($this->request);
        $this->getResponse()->getBody()->write(FrameSet::i()->getCurrent()->get());

        return $this->getResponse();
    }

}