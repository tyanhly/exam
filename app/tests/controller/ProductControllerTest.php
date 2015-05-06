<?php

/**
 *
 * @author tungly
 *         List TestCase
 *         testProductListResponseOk
 *         testProductListHasFailPageParam
 */
class ProductControllerTest extends TestCase
{
    
    /**
     *
     * @author Tung Ly
     */
    public function testProductListResponseOk () {
        
        $this->console("testProductListResponseOk");
        // $this->__setUp();
        $this->call('GET', '/');
        $this->assertResponseOk();
        $this->assertViewHas('products');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testProductListHasFailPageParam () {
        $this->console("testProductListHasFailPageParam");
        // $this->__setUp();
        $this->setExpectedException(
                'Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
        $this->call('GET', '/?page=a');
    }

}
