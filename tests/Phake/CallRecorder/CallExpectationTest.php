<?php
/*
 * Phake - Mocking Framework
 *
 * Copyright (c) 2010, Mike Lively <mike.lively@sellingsource.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *  *  Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *  *  Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *  *  Neither the name of Mike Lively nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Testing
 * @package    Phake
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.digitalsandwich.com/
 */

require_once 'Phake/CallRecorder/CallExpectation.php';
require_once 'Phake.php';

class Phake_CallRecorder_CallExpectationTest extends PHPUnit_Framework_TestCase
{
	public function testToString()
	{
		$mock = $this->getMock('Phake_IMock');
		$mock->expects($this->any())
				->method('__PHAKE_getName')
				->will($this->returnValue('Phake_IMock'));
		
		$matcher1 = Phake::mock('Phake_Matchers_IArgumentMatcher');
		Phake::when($matcher1)->__toString()->thenReturn('100');
		$matcher2 = Phake::mock('Phake_Matchers_IArgumentMatcher');
		Phake::when($matcher2)->__toString()->thenReturn('200');
		$verifierMode = Phake::mock('Phake_CallRecorder_IVerifierMode');
		Phake::when($verifierMode)->__toString()->thenReturn('2 times');

		$expectation = new Phake_CallRecorder_CallExpectation($mock, 'method', array($matcher1, $matcher2), $verifierMode);
		$this->assertEquals(
			"Expected Phake_IMock->method(<100>, <200>) to be called 2 times",
			$expectation->__toString());
	}
}
