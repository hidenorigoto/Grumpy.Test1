<?php
class Foo{
    public function bar($arg) {}
}

class FooTest extends PHPUnit_Framework_TestCase
{
    public function testChangingReturnValuesBasedOnInput()
    {
        $foo = $this->getMockBuilder('Foo')->getMock();
        $foo->expects($this->once())
            ->method('bar')
            ->with('1')
            ->will($this->returnValue('I'));
        $foo->expects($this->once())
            ->method('bar')
            ->with('4')
            ->will($this->returnValue('IV'));
        $foo->expects($this->once())
            ->method('bar')
            ->with('10')
            ->will($this->returnValue('X'));
        $expectedResults = array('I', 'IV', 'X');
        $testResults = array();
        $testResults[] = $foo->bar(1);
        $testResults[] = $foo->bar(4);
        $testResults[] = $foo->bar(10);

        $this->assertEquals($expectedResults, $testResults, 'original coder failed');
    }

    public function testChangingReturnValuesBasedOnInputModifiedOne()
    {
        $foo = $this->getMockBuilder('Foo')->getMock();
        $foo->expects($this->at(0))
            ->method('bar')
            ->with('1')
            ->will($this->returnValue('I'));
        $foo->expects($this->at(1))
            ->method('bar')
            ->with('4')
            ->will($this->returnValue('IV'));
        $foo->expects($this->at(2))
            ->method('bar')
            ->with('10')
            ->will($this->returnValue('X'));
        $expectedResults = array('I', 'IV', 'X');
        $testResults = array();
        $testResults[] = $foo->bar(1);
        $testResults[] = $foo->bar(4);
        $testResults[] = $foo->bar(10);

        $this->assertEquals($expectedResults, $testResults, 'modified1 coder failed');
    }

    public function testChangingReturnValuesBasedOnInputModifiedTwo()
    {
        $foo = $this->getMockBuilder('Foo')->getMock();

        $valueMap = array(
            array(1,  'I'),
            array(4,  'IV'),
            array(10, 'X'),
        );

        $foo->expects($this->any())
            ->method('bar')
            ->will($this->returnValueMap($valueMap));
        $expectedResults = array('I', 'IV', 'X');
        $testResults = array();
        $testResults[] = $foo->bar(1);
        $testResults[] = $foo->bar(4);
        $testResults[] = $foo->bar(10);

        $this->assertEquals($expectedResults, $testResults, 'modified2 code failed');
    }
}