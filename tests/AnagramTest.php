<?php

require_once "./index.php";

class AnagramTest extends PHPUnit\Framework\TestCase {

    public function testEmptyWordbaseEmptyWord() {
        $wordbase = [];
        $word = "";
        $anagrams = findAnagrams($word, $wordbase);
        $this->assertEmpty($anagrams);
    }

    public function testEmptyWordbaseRandomWord() {
        $wordbase = [];
        $word = generateRandomString();
        $anagrams = findAnagrams($word, $wordbase);
        $this->assertEmpty($anagrams);
    }

    public function testNoMatch() {
        $wordbase = ["aaa", "bbb", "ccc"];
        $word = "ddd";
        $anagrams = findAnagrams($word, $wordbase);
        $this->assertEmpty($anagrams);
    }

    public function testSingleMatch() {
        $wordbase = ["baa", "bbb", "ccc"];
        $word = "aba";
        $anagrams = findAnagrams($word, $wordbase);
        $this->assertContains("baa", $anagrams);
    }

    public function testAllMatch() {
        $wordbase = ["abc", "acb", "bac", "bca", "cab", "cba"];
        $word = "abc";
        $anagrams = findAnagrams($word, $wordbase);
        $this->assertNotContains("abc", $anagrams);
        $this->assertContains("acb", $anagrams);
        $this->assertContains("bac", $anagrams);
        $this->assertContains("bac", $anagrams);
        $this->assertContains("bca", $anagrams);
        $this->assertContains("cab", $anagrams);
        $this->assertContains("cba", $anagrams);
    }

    public function testRandom1() {
        $word = generateRandomString(rand(0, 100));
        $wordbase = [];
        $expected_anagrams = [];

        $number_of_matches = rand(0, 100);
        for ($i = 0; $i < $number_of_matches; $i++) {
            $shuffled_string = str_shuffle($word);
            $wordbase[] = $shuffled_string;
            $expected_anagrams[] = $shuffled_string;
        }

        $number_of_random_strings = rand(0, 1000);
        for ($i = 0; $i < $number_of_random_strings; $i++) {
            $random_str = generateRandomString(rand(0, 100));
            $wordbase[] = $random_str;
        }

        $actual_anagrams = findAnagrams($word, $wordbase);

        foreach ($expected_anagrams as $expected_anagram) {
            $this->assertContains($expected_anagram, $actual_anagrams);
        }
    }

    public function testRandom2() {
        $word = generateRandomString(rand(0, 100));
        $wordbase = [];
        $expected_anagrams = [];

        $number_of_matches = rand(0, 100);
        for ($i = 0; $i < $number_of_matches; $i++) {
            $shuffled_string = str_shuffle($word);
            $wordbase[] = $shuffled_string;
            $expected_anagrams[] = $shuffled_string;
        }

        $number_of_random_strings = rand(0, 1000);
        for ($i = 0; $i < $number_of_random_strings; $i++) {
            $random_str = generateRandomString(rand(0, 100));
            $wordbase[] = $random_str;
        }

        $actual_anagrams = findAnagrams($word, $wordbase);

        foreach ($expected_anagrams as $expected_anagram) {
            $this->assertContains($expected_anagram, $actual_anagrams);
        }
    }

    public function testRandom3() {
        $word = generateRandomString(rand(0, 100));
        $wordbase = [];
        $expected_anagrams = [];

        $number_of_matches = rand(0, 100);
        for ($i = 0; $i < $number_of_matches; $i++) {
            $shuffled_string = str_shuffle($word);
            $wordbase[] = $shuffled_string;
            $expected_anagrams[] = $shuffled_string;
        }

        $number_of_random_strings = rand(0, 1000);
        for ($i = 0; $i < $number_of_random_strings; $i++) {
            $random_str = generateRandomString(rand(0, 100));
            $wordbase[] = $random_str;
        }

        $actual_anagrams = findAnagrams($word, $wordbase);

        foreach ($expected_anagrams as $expected_anagram) {
            $this->assertContains($expected_anagram, $actual_anagrams);
        }
    }
}

function generateRandomString($length = 10) : string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
