<?php


declare( strict_types = 1 );


namespace JDWX\Web\Framework\Tests;


require_once __DIR__ . '/Shims/MyRouter.php';


use JDWX\Web\Backends\MockServer;
use JDWX\Web\Framework\AbstractStaticRoute;
use JDWX\Web\Framework\ResponseInterface;
use JDWX\Web\Framework\StaticFileRoute;
use JDWX\Web\Framework\Tests\Shims\MyRouter;
use JDWX\Web\Request;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( AbstractStaticRoute::class )]
#[CoversClass( StaticFileRoute::class )]
final class StaticFileRouteTest extends TestCase {


    public function testMake() : void {
        $req = Request::synthetic( i_server: new MockServer( [ 'REQUEST_METHOD' => 'GET' ] ) );
        $rtr = new MyRouter( i_req: $req );
        $route = StaticFileRoute::make( $rtr, __DIR__ . '/../example/static/example.txt' );
        $rsp = $route->handle( '/', '', [] );
        assert( $rsp instanceof ResponseInterface );
        $page = $rsp->getPage();
        self::assertSame( 'This is a test.', $page->render() );
        self::assertSame( 'text/plain', $page->getContentType() );
    }


}
