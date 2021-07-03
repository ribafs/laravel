randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL) // 48.8932

                'name'      => $faker->name,
                'price'      => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 100) // 48.89

randomDigit             // 7
randomDigitNot(5)       // 0, 1, 2, 3, 4, 6, 7, 8, or 9
randomDigitNotNull      // 5
randomNumber($nbDigits = NULL, $strict = false) // 79907610
randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL) // 48.8932
numberBetween($min = 1000, $max = 9000) // 8567
randomLetter            // 'b'
// returns randomly ordered subsequence of a provided array
randomElements($array = array ('a','b','c'), $count = 1) // array('c')
randomElement($array = array ('a','b','c')) // 'b'
shuffle('hello, world') // 'rlo,h eoldlw'
shuffle(array(1, 2, 3)) // array(2, 1, 3)
numerify('Hello ###') // 'Hello 609'
lexify('Hello ???') // 'Hello wgt'
bothify('Hello ##??') // 'Hello 42jz'
asciify('Hello ***') // 'Hello R6+'
regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'); // sm0@y8k96a.ej

https://github.com/fzaninotto/Faker
