<?php

class com_wiris_quizzes_test_Tester {
	public function __construct() { 
	}
	public function testBugs() {
		$str = "<question><wirisCasSession><![CDATA[<session lang=\"fr\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\">library</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mi>aléa</mi><mo>(</mo><mn>1</mn><mo>.</mo><mo>.</mo><mn>10</mn><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>b</mi><mo>=</mo><mi>aléa</mi><mo>(</mo><mo>-</mo><mn>10</mn><mo>.</mo><mo>.</mo><mn>1</mn><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>b</mi><mo>=</mo><mi>max</mi><mo>(</mo><mi>b</mi><mo>,</mo><mn>0</mn><mo>)</mo></math></input></command></group></library><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"/></input></command></group></session>]]></wirisCasSession><correctAnswers><correctAnswer type=\"mathml\"><![CDATA[<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mo>#</mo><mi>a</mi></math>]]></correctAnswer></correctAnswers><assertions><assertion name=\"syntax_expression\"/><assertion name=\"equivalent_symbolic\"/></assertions><options><option name=\"tolerance\">10^(-4)</option><option name=\"relative_tolerance\">false</option><option name=\"precision\">4</option><option name=\"implicit_times_operator\">false</option><option name=\"times_operator\">·</option><option name=\"imaginary_unit\">i</option>\x09</options>\x09<localData><data name=\"inputField\">inlineEditor</data><data name=\"gradeCompound\">and</data><data name=\"gradeCompoundDistribution\"/><data name=\"casSession\"/></localData></question>";
		$b = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$q = $b->readQuestion($str);
		$qi = $b->newQuestionInstance();
		$qi->setRandomSeed(12345);
		$r = $b->newVariablesRequest("#a", $q, $qi);
		$s = $b->getQuizzesService();
		$rp = $s->execute($r);
		$qi->update($rp);
		$a = $qi->expandVariablesText("#a");
		if(!($a === "10")) {
			throw new HException("Failed test");
		}
	}
	public function testCache() {
		$qstr = "<question id=\"cachemiss\"><wirisCasSession><![CDATA[<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\" xml:lang=\"en\">variables</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mi>random</mi><mo>(</mo><mn>1</mn><mo>.</mo><mo>.</mo><mn>10</mn><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>b</mi><mo>=</mo><mi>random</mi><mo>(</mo><mn>1</mn><mo>.</mo><mo>.</mo><mn>10</mn><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>c</mi><mo>=</mo><mi>a</mi><mo>+</mo><mi>b</mi></math></input></command></group></library></session>]]></wirisCasSession><correctAnswers><correctAnswer></correctAnswer></correctAnswers><assertions><assertion name=\"syntax_expression\"/><assertion name=\"equivalent_symbolic\"/></assertions><options><option name=\"tolerance\">10^(-4)</option><option name=\"relative_tolerance\">false</option><option name=\"precision\">4</option><option name=\"implicit_times_operator\">false</option><option name=\"times_operator\">·</option><option name=\"imaginary_unit\">i</option></options><localData><data name=\"inputField\">inlineEditor</data><data name=\"gradeCompound\">and</data><data name=\"gradeCompoundDistribution\"></data><data name=\"casSession\"/></localData></question>";
		$text = "#a  + #b = #c";
		$b = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$q = $b->readQuestion($qstr);
		$s = $b->getQuizzesService();
		$qi = $b->newQuestionInstance();
		$s1 = Date::now()->getTime();
		$qi->update($s->execute($b->newVariablesRequest($text, $q, $qi)));
		$t1 = Date::now()->getTime() - $s1;
		$str1 = $qi->expandVariables($text);
		if(_hx_index_of($str1, "#", null) !== -1 || _hx_index_of($str1, "<math", null) === -1) {
			throw new HException("Failed test");
		}
		$qi = $b->newQuestionInstance();
		$s2 = Date::now()->getTime();
		$qi->update($s->execute($b->newVariablesRequest($text, $q, $qi)));
		$t2 = Date::now()->getTime() - $s2;
		$str2 = $qi->expandVariables($text);
		if(_hx_index_of($str2, "#", null) !== -1 || _hx_index_of($str2, "<math", null) === -1) {
			throw new HException("Failed test");
		}
		if($t2 >= $t1) {
			haxe_Log::trace("WARNING: Uncached question was faster than cached one! time miss: " . _hx_string_rec($t1, "") . "ms, time hit: " . _hx_string_rec($t2, "") . "ms.", _hx_anonymous(array("fileName" => "Tester.hx", "lineNumber" => 417, "className" => "com.wiris.quizzes.test.Tester", "methodName" => "testCache")));
		}
	}
	public function testFilter() {
		$text = "Hola <math><mn>3</mn></math> hola <math xmlns=\"http://www.w3.org/1998/Math/MathML\"><msqrt><mn>3</mn></msqrt></math>";
		$filter = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getMathFilter();
		$filtered = $filter->filter($text);
		$expected = "Hola <img src=\"" . com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getConfiguration()->get(com_wiris_quizzes_api_ConfigurationKeys::$PROXY_URL) . "?service=cache&amp;name=5ca7d1107389675d32b56ec097464c14.png\" align=\"middle\" /> hola <img src=\"" . com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getConfiguration()->get(com_wiris_quizzes_api_ConfigurationKeys::$PROXY_URL) . "?service=cache&amp;name=61eed805aa7caf23565ff147e24a35df.png\" align=\"middle\" />";
		if(!($expected === $filtered)) {
			throw new HException("Failed test filter. \x0AGot: " . $filtered . "\x0AExpected: " . $expected . "\x0A");
		}
	}
	public function testConcurrency() {
	}
	public function testPerformance() {
		$text = "<p><span style=\"font-family: 'times new roman', times, serif; font-size: medium;\">Rounded to the nearest tenth of a foot, a #F foot mountain peak is _____ miles tall.  <br /></span></p>" . "<p><span style=\"text-decoration: underline;\"><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">UNIT</span><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"> CONVERSIONS</span></strong></span></p>\x0A" . "<ul>\x0A" . "<li><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">When converting from a larger to a smaller unit, multiply.</span></li>\x0A" . "<li><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">When converting from a smaller to a larger unit, divide.</span></li>\x0A" . "</ul>\x0A" . "<p><strong><span style=\"text-decoration: underline;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">COMMON MEASUREMENT CONVERSIONS AND FACTS</span></span></strong></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Length</span>:</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Customary:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 foot <em>(</em><em>ft</em><em>)</em> = 12 inches <em>(in)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 yard <em>(yd)</em> = 3 feet <em>(ft)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 mile <em>(mi)</em> = 5,280 feet <em>(ft)</em></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Metric:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 centimeter <em>(cm</em><em>)</em> = 10 millimeters <em>(mm)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 meter <em>(m)</em> = 100 centimeters <em>(cm)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 kilometer <em>(km)</em> = 1,000 meters <em>(m)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tools used to measure length: ruler, yard stick, meter stick, measuring tape</span></p>\x0A" . "<p><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><strong><span style=\"text-decoration: underline;\">Time</span>:</strong><br /></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 day = 24 hours <em>(hrs)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 hour <em>(hr)</em> = 60 minutes <em>(min)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 minute <em>(min)</em> = 60 seconds <em>(sec)</em></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 week = 7 days</span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 year = 365 days</span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 year = 52 weeks</span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tools used to measure time: clock, calendar</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Mass</span> (Metric):</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 gram <em>(g</em><em>)</em> = 1,000 milligrams <em>(mg)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 kilogram <em>(kg)</em> = 1,000 grams <em>(g)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tool used to measure mass: scale</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Weight</span> (Customary):</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 pound <em>(lb</em><em>)</em> = 16 ounces <em>(oz)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 ton = 2,000 pounds <em>(lbs)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tool used to measure weight: scale</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Volume (Capacity)</span>:</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Customary:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 cup <em>(c</em><em>)</em> = 8 fluid ounces <em>(oz)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 pint <em>(pt)</em> = 2 cups <em>(c)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 quart <em>(qt)</em> = 2 pints <em>(pt)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 gallon <em>(gal)</em> = 4 quarts <em>(qt)</em></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Metric:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 liter <em>(L</em><em>)</em> = 1,000 milliliters <em>(ml)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tools used to measure volume: measuring cups</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Angle</span>:</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Line = 180°</span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Circle = 360°</span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tool used to measure angle: protractor</span></p>" . "<p><strong><span style=\"background-color: #aaffaa;\">#CF</span></strong></p>" . "<p><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Your answer is correct, but it is not rounded to the nearest tenth.</span></p>" . "<p><span style=\"text-decoration: underline;\"><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">UNIT</span><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"> CONVERSIONS</span></strong></span></p>\x0A" . "<ul>\x0A" . "<li><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">When converting from a larger to a smaller unit, multiply.</span></li>\x0A" . "<li><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">When converting from a smaller to a larger unit, divide.</span></li>\x0A" . "</ul>\x0A" . "<p><strong><span style=\"text-decoration: underline;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">COMMON MEASUREMENT CONVERSIONS AND FACTS</span></span></strong></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Length</span>:</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Customary:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 foot <em>(</em><em>ft</em><em>)</em> = 12 inches <em>(in)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 yard <em>(yd)</em> = 3 feet <em>(ft)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 mile <em>(mi)</em> = 5,280 feet <em>(ft)</em></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Metric:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 centimeter <em>(cm</em><em>)</em> = 10 millimeters <em>(mm)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 meter <em>(m)</em> = 100 centimeters <em>(cm)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 kilometer <em>(km)</em> = 1,000 meters <em>(m)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tools used to measure length: ruler, yard stick, meter stick, measuring tape</span></p>\x0A" . "<p><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><strong><span style=\"text-decoration: underline;\">Time</span>:</strong><br /></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 day = 24 hours <em>(hrs)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 hour <em>(hr)</em> = 60 minutes <em>(min)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 minute <em>(min)</em> = 60 seconds <em>(sec)</em></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 week = 7 days</span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 year = 365 days</span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 year = 52 weeks</span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tools used to measure time: clock, calendar</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Mass</span> (Metric):</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 gram <em>(g</em><em>)</em> = 1,000 milligrams <em>(mg)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 kilogram <em>(kg)</em> = 1,000 grams <em>(g)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tool used to measure mass: scale</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Weight</span> (Customary):</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 pound <em>(lb</em><em>)</em> = 16 ounces <em>(oz)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 ton = 2,000 pounds <em>(lbs)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tool used to measure weight: scale</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Volume (Capacity)</span>:</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Customary:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 cup <em>(c</em><em>)</em> = 8 fluid ounces <em>(oz)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 pint <em>(pt)</em> = 2 cups <em>(c)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 quart <em>(qt)</em> = 2 pints <em>(pt)</em></span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 gallon <em>(gal)</em> = 4 quarts <em>(qt)</em></span></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><em>Metric:</em></span><br /> <span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">1 liter <em>(L</em><em>)</em> = 1,000 milliliters <em>(ml)</em></span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tools used to measure volume: measuring cups</span></p>\x0A" . "<p><strong><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\"><span style=\"text-decoration: underline;\">Angle</span>:</span></strong></p>\x0A" . "<p style=\"padding-left: 30px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Line = 180°</span><br /><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Circle = 360°</span></p>\x0A" . "<p style=\"padding-left: 60px;\"><span style=\"background-color: #ffaaaa; font-family: 'times new roman', times, serif;\">Tool used to measure angle: protractor</span></p>";
		$session = "<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\" xml:lang=\"en\">variables</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><apply><csymbol definitionURL=\"http://www.wiris.com/XML/csymbol\">repeat</csymbol><mtable><mtr><mtd><mi>f</mi><mo>(</mo><mo>)</mo><mo>=</mo><mi>random</mi><mo>(</mo><mn>10001</mn><mo>,</mo><mn>15999</mn><mo>)</mo></mtd></mtr><mtr><mtd><mi>F</mi><mo>=</mo><mi>f</mi><mo>(</mo><mo>)</mo></mtd></mtr><mtr><mtd><mi>m</mi><mo>=</mo><mfrac><mi>F</mi><mn>528</mn></mfrac></mtd></mtr><mtr><mtd><mi>M</mi><mo>=</mo><mi>round</mi><mo>(</mo><mi>m</mi><mo>)</mo><mo>*</mo><mn>0</mn><mo>.</mo><mn>1</mn></mtd></mtr><mtr><mtd><mi>Ans</mi><mo>=</mo><mi>M</mi></mtd></mtr><mtr><mtd><mi>N</mi><mo>=</mo><mi>round</mi><mo>(</mo><mi>M</mi><mo>)</mo></mtd></mtr><mtr><mtd><mi>P</mi><mo>=</mo><mfrac><mi>F</mi><mn>5280</mn></mfrac></mtd></mtr></mtable><mrow><mi>M</mi><mo>=</mo><mi>N</mi></mrow></apply></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>WATest</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>:=</mo><mo>(</mo><mi>x</mi><mo>&ne;</mo><mi>Ans</mi><mo>)</mo><mo>?</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>u</mi><mo>(</mo><mo>)</mo><mo>=</mo><mi>random</mi><mo>(</mo><mn>1</mn><mo>,</mo><mn>23</mn><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>U</mi><mo>=</mo><mi>u</mi><mo>(</mo><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>1</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Excellent</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>2</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Outstanding</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>3</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>You</mi><mo>&nbsp;</mo><mi>got</mi><mo>&nbsp;</mo><mi>it</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>4</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>That</mi><mo>&apos;</mo><mi>s</mi><mo>&nbsp;</mo><mi>it</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>5</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Correct</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>6</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>You</mi><mo>&nbsp;</mo><mi>rock</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>7</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Perfect</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>8</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Wow</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>9</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Phenomenal</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>10</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Superstar</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>11</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Amazing</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>12</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Nice</mi><mo>&nbsp;</mo><mi>going</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>13</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>You</mi><mo>&apos;</mo><mi>re</mi><mo>&nbsp;</mo><mi>a</mi><mo>&nbsp;</mo><mi>rock</mi><mo>&nbsp;</mo><mi>star</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>14</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Mathlete</mi><mo>&nbsp;</mo><mi>extraordinaire</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>15</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Right</mi><mo>&nbsp;</mo><mi>on</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>16</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Genius</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>17</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Tremendous</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>18</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Stupendous</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>19</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Magnificent</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>20</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Incredible</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>21</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>You</mi><mo>&nbsp;</mo><mi>win</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>22</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>You</mi><mo>&apos;</mo><mi>re</mi><mo>&nbsp;</mo><mi>on</mi><mo>&nbsp;</mo><mi>fire</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>Pos</mi><mo>(</mo><mn>23</mn><mo>)</mo><mo>=</mo><mo>&quot;</mo><mi>Awesome</mi><mo>!</mo><mo>&quot;</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>CF</mi><mo>=</mo><mi>Pos</mi><mo>(</mo><mi>U</mi><mo>)</mo></math></input></command></group></library></session>";
		$qb = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$q = $qb->newQuestion();
		$qq = _hx_deref(($q))->getImpl();
		$qq->wirisCasSession = $session;
		$qi = $qb->newQuestionInstance();
		$r = $qb->newVariablesRequest($text, $q, $qi);
		$qi->update($qb->getQuizzesService()->execute($r));
		$expanded = $qi->expandVariables($text);
		haxe_Log::trace($expanded, _hx_anonymous(array("fileName" => "Tester.hx", "lineNumber" => 367, "className" => "com.wiris.quizzes.test.Tester", "methodName" => "testPerformance")));
	}
	public function testTranslation() {
		$en = "<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\">library</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mi>random</mi><mo>(</mo><mn>1</mn><mo>.</mo><mo>.</mo><mn>10</mn><mo>)</mo></math></input></command></group></library></session>";
		$fr = "<session lang=\"fr\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\">library</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mi>aléa</mi><mo>(</mo><mn>1</mn><mo>.</mo><mo>.</mo><mn>10</mn><mo>)</mo></math></input></command></group></library></session>";
		$q = new com_wiris_quizzes_impl_QuestionImpl();
		$q->wirisCasSession = $en;
		$r = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->newTranslationRequest($q, "fr");
		$s = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getQuizzesService();
		$q->update($s->execute($r));
		$tr = $q->wirisCasSession;
		if(!($fr === trim($tr))) {
			throw new HException("Expected: \x0A" . $fr . "\x0A Got:\x0A" . $tr . "\x0A");
		}
	}
	public function testEncodings() {
		$session = "<session lang=\"en\" version=\"2.0\"><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mi>x</mi><mo>*</mo><mi>y</mi><mo>+</mo><reals/><cn>-&infin;</cn><mo>+</mo><pi/><mo>&nbsp;</mo><csymbol definitionURL=\"http://.../units/minute/angular\">&apos;</csymbol><csymbol definitionURL=\"http://.../units/degree/angular\">&deg;</csymbol><mi>&Theta;</mi></math></input><output><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><pi/><mo>*</mo><mfenced><mrow><csymbol definitionURL=\"http://.../units/degree/angular\">&deg;</csymbol><mo>&nbsp;</mo><csymbol definitionURL=\"http://.../units/minute/angular\">&apos;</csymbol></mrow></mfenced><mo>+</mo><mfenced><mrow><reals/><mo>+</mo><cn>-&infin;</cn><mo>+</mo><mi>x</mi><mo>*</mo><mi>y</mi></mrow></mfenced><mo>+</mo><mi>&Theta;</mi></math></output></command></group><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"/></input></command></group></session>";
		$text = "Encode #a.";
		$result = "Encode <math><mrow><mi mathvariant=\"normal\">&#960;</mi><mo>&#183;</mo><mfenced><mrow><mo>&#176;</mo><mo>'</mo></mrow></mfenced><mo>+</mo><mfenced><mrow><mo>&#8477;</mo><mo>+</mo><mo>-&#8734;</mo><mo>+</mo><mi>x</mi><mo>&#183;</mo><mi>y</mi></mrow></mfenced><mo>+</mo><mi>&#920;</mi></mrow></math>.";
		$q = new com_wiris_quizzes_impl_QuestionImpl();
		$qi = new com_wiris_quizzes_impl_QuestionInstanceImpl();
		$q->wirisCasSession = $session;
		$r = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->newVariablesRequest($text, $q, $qi);
		$s = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getQuizzesService();
		$qi->update($s->execute($r));
		$expanded = $qi->expandVariables($text);
		if(!($expanded === $result)) {
			throw new HException("Failed Test. Expected:\x0A" . $result . ".\x0AGot:\x0A" . $expanded . "\x0A");
		}
		$text2 = "• #a";
		$session2 = "<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mi style=\"color:#ffc800\">variables</mi><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mn>123</mn></math></input></command></group></library></session>";
		$result2 = "• 123";
		$q = new com_wiris_quizzes_impl_QuestionImpl();
		$qi = new com_wiris_quizzes_impl_QuestionInstanceImpl();
		$q->wirisCasSession = $session2;
		$r = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->newVariablesRequest($text2, $q, $qi);
		$qi->update($s->execute($r));
		$expanded2 = $qi->expandVariablesText($text2);
		if(!($expanded2 === $result2)) {
			throw new HException("Failed Test. Expected:\x0A" . $result2 . ".\x0AGot:\x0A" . $expanded2 . "\x0A");
		}
	}
	public function testRandomQuestion() {
		$session = "<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\" xml:lang=\"en\">variables</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mn>1</mn></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>b</mi><mo>=</mo><mn>2</mn></math></input></command></group></library></session>";
		$correctAnswer = "#a";
		$text = "Hello! How much is #b - #a?";
		$q = new com_wiris_quizzes_impl_QuestionImpl();
		$q->wirisCasSession = $session;
		$q->setAssertion(com_wiris_quizzes_impl_Assertion::$SYNTAX_EXPRESSION, 0, 0);
		$q->setAssertion(com_wiris_quizzes_impl_Assertion::$EQUIVALENT_SYMBOLIC, 0, 0);
		$q->setAssertion(com_wiris_quizzes_impl_Assertion::$CHECK_SIMPLIFIED, 0, 0);
		$qi = new com_wiris_quizzes_impl_QuestionInstanceImpl();
		$rb = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$vqr = $rb->newVariablesRequest($text . " " . $correctAnswer, $q, $qi);
		$quizzes = new com_wiris_quizzes_impl_QuizzesServiceImpl();
		$vqs = $quizzes->execute($vqr);
		$qi->update($vqs);
		$deliveryText = $qi->expandVariables($text);
		if(!($deliveryText === "Hello! How much is <math><mrow><mn>2</mn></mrow></math> - <math><mrow><mn>1</mn></mrow></math>?")) {
			throw new HException("Failed Test!");
		}
		$userAnswer = "1";
		$eqr = $rb->newEvalRequest($correctAnswer, $userAnswer, $q, $qi);
		$eqs = $quizzes->execute($eqr);
		$qi->update($eqs);
		$syntax = $qi->isAnswerSyntaxCorrect(0);
		$correct = $qi->isAnswerCorrect(0);
		if(!$correct || !$syntax) {
			throw new HException("Failed Test!");
		}
	}
	public function testTolerance() {
		$correctAnswer = "<math><mfrac><mn>1</mn><mn>2</mn></mfrac></math>";
		$userAnswer = "0.501";
		$rb = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$q = _hx_deref(($rb->newQuestion()))->getImpl();
		$q->setOption(com_wiris_quizzes_impl_Option::$OPTION_TOLERANCE, "10^(-3)");
		$req = $rb->newEvalRequest($correctAnswer, $userAnswer, $q, null);
		$s = $rb->getQuizzesService();
		$res = $s->execute($req);
		$qi = $rb->newQuestionInstance();
		$qi->update($res);
		if($qi->isAnswerCorrect(0)) {
			throw new HException("Failed test! ");
		}
		$reqi = $req;
		$reqi->question->getImpl()->setOption(com_wiris_quizzes_impl_Option::$OPTION_TOLERANCE, "10^(-2)");
		$res = $s->execute($req);
		$qi = $rb->newQuestionInstance();
		$qi->update($res);
		if(!$qi->isAnswerCorrect(0)) {
			throw new HException("Failed test! ");
		}
	}
	public function testOpenQuestion() {
		$correctAnswer = "1+1";
		$userAnswer = "2";
		$rb = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$eqs = $rb->newEvalRequest($correctAnswer, $userAnswer, null, null);
		$quizzes = $rb->getQuizzesService();
		$vqs = $quizzes->execute($eqs);
		$qi = $rb->newQuestionInstance();
		$qi->update($vqs);
		$correct = $qi->isAnswerCorrect(0);
		if(!$correct) {
			throw new HException("Failed test!");
		}
	}
	public function testImages() {
		$algorithm = "<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mtext style=\"color:#ffc800\" xml:lang=\"en\">variables</mtext><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>p</mi><mo>&nbsp;</mo><mo>=</mo><mo>&nbsp;</mo><mi>plot</mi><mo>(</mo><mi>sin</mi><mo>(</mo><mi>x</mi><mo>)</mo><mo>)</mo></math></input></command></group></library></session>";
		$text = "#p";
		$expandedLinux = "<img id=\"4e0fa2b5e6d8b12ce9fda6541fdb5557\" src=\"" . com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getConfiguration()->get(com_wiris_quizzes_api_ConfigurationKeys::$PROXY_URL) . "?service=cache&amp;name=4e0fa2b5e6d8b12ce9fda6541fdb5557.png\"/>";
		$expandedWindows = "<img id=\"25e134841ec38381d3baa862622edf98\" src=\"" . com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance()->getConfiguration()->get(com_wiris_quizzes_api_ConfigurationKeys::$PROXY_URL) . "?service=cache&amp;name=25e134841ec38381d3baa862622edf98.png\"/>";
		$q = new com_wiris_quizzes_impl_QuestionImpl();
		$q->wirisCasSession = $algorithm;
		$rb = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$qi = new com_wiris_quizzes_impl_QuestionInstanceImpl();
		$r = $rb->newVariablesRequest($text, $q, $qi);
		$s = new com_wiris_quizzes_impl_QuizzesServiceImpl();
		$p = $s->execute($r);
		$qi->update($p);
		if(!$qi->isCacheReady()) {
			throw new HException("Failed test!. Variable cache should be ready immediately after Question Instance update.\x0A");
		}
		$res = $qi->expandVariables($text);
		if(!($res === $expandedLinux) && !($res === $expandedWindows)) {
			throw new HException("Failed test!. Got:\x0A" . $res);
		}
		$r = $rb->newVariablesRequest(null, $q, $qi);
		$p = $s->execute($r);
		$qi->update($p);
		$res = $qi->expandVariables($text);
		if(!($res === $expandedLinux) && !($res === $expandedWindows)) {
			throw new HException("Failed test!. Got:\x0A" . $res);
		}
	}
	public function testLang() {
		$algorithm = "<session lang=\"ca\" version=\"2.0\"><library closed=\"false\"><mi style=\"color:#ffc800\">variables</mi><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>a</mi><mo>=</mo><mi>sin</mi><mo>(</mo><mi>x</mi><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>t</mi><mo>=</mo><mo>(</mo><mn>1</mn><mo>==</mo><mn>1</mn><mo>?</mo><mo>)</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>f</mi><mo>=</mo><mo>(</mo><mn>1</mn><mo>==</mo><mn>0</mn><mo>?</mo><mo>)</mo></math></input></command></group></library></session>";
		$text = "#a #t #f";
		$textexpanded = "sin(x) cert fals";
		$q = new com_wiris_quizzes_impl_QuestionImpl();
		$q->wirisCasSession = $algorithm;
		$rb = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$qi = $rb->newQuestionInstance();
		$r = $rb->newVariablesRequest($text, $q, $qi);
		$s = $rb->getQuizzesService();
		$p = $s->execute($r);
		$qi->update($p);
		if(!$qi->isCacheReady()) {
			throw new HException("Failed test!. Variable cache should be ready immediately after Question Instance update.\x0A");
		}
		$res = $qi->expandVariablesText($text);
		if(!($res === $textexpanded)) {
			throw new HException("Failed test!. Got:\x0A" . $res);
		}
		if(!$qi->getBooleanVariableValue("#t")) {
			throw new HException("Failed test!. #t was true");
		}
		if($qi->getBooleanVariableValue("f")) {
			throw new HException("Failed test!. f was false");
		}
		$langs = new _hx_array(array("en", "es"));
		$tests = new _hx_array(array("Input method", "Método de entrada"));
		$i = null;
		{
			$_g1 = 0; $_g = $langs->length;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				$g = new com_wiris_quizzes_impl_HTMLGui($langs[$i1]);
				$html = $g->getTabCorrectAnswer($q, 0, 0, new com_wiris_quizzes_impl_HTMLGuiConfig("wirisopenanswer"));
				if(_hx_index_of($html, $tests[$i1], null) === -1) {
					throw new HException("Failed test!. String \"" . $tests[$i1] . "\" not found in popup for language \"" . $langs[$i1] . "\".\x0A");
				}
				unset($i1,$html,$g);
			}
		}
	}
	public function testCompound() {
		$correctAnswer = "<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>x</mi><mo>=</mo><msqrt><mn>2</mn></msqrt><mspace linebreak=\"newline\"/><mi>y</mi><mo>=</mo><mi>x</mi><mspace linebreak=\"newline\"/><mi>z</mi><mo>=</mo><mn>0</mn></math>";
		$userCorrectAnswer = "<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>x</mi><mo>=</mo><msqrt><mn>1</mn><mo>+</mo><mn>1</mn></msqrt><mspace linebreak=\"newline\"/><mi>y</mi><mo>=</mo><mi>x</mi><mspace linebreak=\"newline\"/><mi>z</mi><mo>=</mo><mn>0</mn></math>";
		$userIncorectAnswer = "<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>x</mi><mo>=</mo><mn>0</mn><mspace linebreak=\"newline\"/><mi>y</mi><mo>=</mo><mi>x</mi><mspace linebreak=\"newline\"/><mi>z</mi><mo>=</mo><mn>0</mn></math>";
		$userIncorrectAnswer2 = "<math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>x</mi><mo>=</mo><msqrt><mn>2</mn></msqrt></math>";
		$u = new com_wiris_quizzes_impl_UserData();
		$u->setUserCompoundAnswer(3, 0, "<math><msqrt><mn>2</mn></msqrt></math>");
		$u->setUserCompoundAnswer(3, 1, "x");
		$u->setUserCompoundAnswer(3, 2, "0");
		$userCorrectAnswer2 = _hx_array_get($u->answers, 3)->content;
		$builder = com_wiris_quizzes_impl_QuizzesBuilderImpl::getInstance();
		$q = $builder->newQuestion();
		$qq = _hx_deref(($q))->getImpl();
		$qq->setLocalData(com_wiris_quizzes_impl_LocalData::$KEY_OPENANSWER_COMPOUND_ANSWER, com_wiris_quizzes_impl_LocalData::$VALUE_OPENANSWER_COMPOUND_ANSWER_TRUE);
		$qi = $builder->newQuestionInstance();
		$bb = $builder;
		$r = $bb->newEvalMultipleAnswersRequest(new _hx_array(array($correctAnswer)), new _hx_array(array($userCorrectAnswer, $userIncorectAnswer, $userIncorrectAnswer2, $userCorrectAnswer2)), $q, $qi);
		$s = $builder->getQuizzesService()->execute($r);
		$qi->update($s);
		$qqi = $qi;
		if(!$qqi->isAnswerMatching(0, 0)) {
			throw new HException("Failed test!");
		}
		if($qqi->isAnswerMatching(0, 1)) {
			throw new HException("Failed test!");
		}
		if($qqi->isAnswerMatching(0, 2)) {
			throw new HException("Failed test!");
		}
		if(!$qqi->isAnswerMatching(0, 3)) {
			throw new HException("Failed test!");
		}
		$qq->setLocalData(com_wiris_quizzes_impl_LocalData::$KEY_OPENANSWER_COMPOUND_ANSWER_GRADE, com_wiris_quizzes_impl_LocalData::$VALUE_OPENANSWER_COMPOUND_ANSWER_GRADE_DISTRIBUTE);
		$qq->setLocalData(com_wiris_quizzes_impl_LocalData::$KEY_OPENANSWER_COMPOUND_ANSWER_GRADE_DISTRIBUTION, "20% 30% 50%");
		if($qqi->getAnswerGrade(0, 0, $qq) !== 1.0) {
			throw new HException("Failed test!");
		}
		if($qqi->getAnswerGrade(0, 1, $qq) !== 0.8) {
			throw new HException("Failed test!");
		}
		if($qqi->getAnswerGrade(0, 2, $qq) !== 0.2) {
			throw new HException("Failed test!");
		}
		if($qqi->getAnswerGrade(0, 3, $qq) !== 1.0) {
			throw new HException("Failed test!");
		}
		$qq->setLocalData(com_wiris_quizzes_impl_LocalData::$KEY_OPENANSWER_COMPOUND_ANSWER_GRADE, com_wiris_quizzes_impl_LocalData::$VALUE_OPENANSWER_COMPOUND_ANSWER_GRADE_DISTRIBUTE);
		$qq->removeLocalData(com_wiris_quizzes_impl_LocalData::$KEY_OPENANSWER_COMPOUND_ANSWER_GRADE_DISTRIBUTION);
		if($qqi->getAnswerGrade(0, 1, $qq) !== 0.67) {
			throw new HException("Failed test!");
		}
		if($qqi->getAnswerGrade(0, 2, $qq) !== 0.34) {
			throw new HException("Failed test!");
		}
		$correctAnswer = "<math><mtable columnalign=\"left\" rowspacing=\"0\"><mtr><mtd><mi>x</mi><mo>=</mo><msqrt><mn>2</mn></msqrt></mtd></mtr><mtr><mtd><mi>y</mi><mo>=</mo><mi>x</mi></mtd></mtr><mtr><mtd><mi>z</mi><mo>=</mo><mn>0</mn></mtd></mtr></mtable></math>";
		$r = $builder->newEvalRequest($correctAnswer, $userCorrectAnswer, $q, $qi);
		$s = $builder->getQuizzesService()->execute($r);
		$qi->update($s);
		if(!$qqi->isAnswerMatching(0, 0)) {
			throw new HException("Failed test!");
		}
		$qq->wirisCasSession = "<session lang=\"en\" version=\"2.0\"><library closed=\"false\"><mi style=\"color:#ffc800\">variables</mi><group><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>test</mi><mo>(</mo><mi>a</mi><mo>,</mo><mi>b</mi><mo>,</mo><mi>c</mi><mo>)</mo><mo>:</mo><mo>=</mo><mfenced><mrow><mi>a</mi><mo>==</mo><msqrt><mn>2</mn></msqrt><mo>&and;</mo><mi>b</mi><mo>==</mo><mi>x</mi><mo>&and;</mo><mi>c</mi><mo>==</mo><mn>0</mn></mrow></mfenced><mo>&nbsp;</mo><mo>?</mo></math></input></command><command><input><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mi>test2</mi><mo>(</mo><mi>a</mi><mo>,</mo><mi>b</mi><mo>,</mo><mi>c</mi><mo>)</mo><mo>:</mo><mo>=</mo><mo>(</mo><mi>a</mi><mo>==</mo><mn>0</mn><mo>&and;</mo><mi>b</mi><mo>==</mo><mn>0</mn><mo>&and;</mo><mi>c</mi><mo>==</mo><mn>0</mn><mo>)</mo><mo>&nbsp;</mo><mo>?</mo></math></input></command></group></library></session>";
		$qq->setParametrizedAssertion(com_wiris_quizzes_impl_Assertion::$EQUIVALENT_FUNCTION, 0, 0, new _hx_array(array("test")));
		$qq->setParametrizedAssertion(com_wiris_quizzes_impl_Assertion::$EQUIVALENT_FUNCTION, 1, 0, new _hx_array(array("test2")));
		$r = $builder->newEvalMultipleAnswersRequest(new _hx_array(array($correctAnswer, $correctAnswer)), new _hx_array(array($userCorrectAnswer)), $q, $qi);
		$s = $builder->getQuizzesService()->execute($r);
		$qi->update($s);
		if(!($qqi->getAnswerGrade(0, 0, $q) === 1.0)) {
			throw new HException("Failed test!");
		}
		if(!($qqi->getAnswerGrade(1, 0, $q) === 0.0)) {
			throw new HException("Failed test!");
		}
	}
	public function run() {
		$start = Date::now();
		$this->testBugs();
		$this->testCache();
		$this->testOpenQuestion();
		$this->testFilter();
		$this->testEncodings();
		$this->testConcurrency();
		$this->testCompound();
		$this->testTranslation();
		$this->testTolerance();
		$this->testRandomQuestion();
		$this->testImages();
		$h = new com_wiris_quizzes_impl_HTMLTools();
		$h->unitTest();
		$this->testBugs();
		$this->testLang();
		$end = Date::now();
		haxe_Log::trace("Successful test!. Time: " . _hx_string_rec(($end->getTime() - $start->getTime()), "") . "ms.", _hx_anonymous(array("fileName" => "Tester.hx", "lineNumber" => 49, "className" => "com.wiris.quizzes.test.Tester", "methodName" => "run")));
	}
	static function main() {
		$t = new com_wiris_quizzes_test_Tester();
		$t->run();
	}
	function __toString() { return 'com.wiris.quizzes.test.Tester'; }
}
