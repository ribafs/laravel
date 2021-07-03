<?php

    // dateAddDays('2019-03-03', '10 days', 'd/m/Y');
    function dateAddDays($date, $interval, $format){
        $datetime = date_create($date);
        date_add($datetime, date_interval_create_from_date_string($interval));       
        $result = date_format($datetime, $format);
        return $result;
    }

    // ageYears('1956-08-03', '2020-11-02');
    function ageYears($dateBirth, $dateNow, $format='%y'){
        $datetime1 = date_create($dateBirth);
        $datetime2 = date_create($dateNow);
       
        $interval = date_diff($datetime1, $datetime2);
       
        return $interval->format($format);
    }

    // Ano atual
    function year(){// 2019
        $result = new \DateTime();
        return $result->format('Y');
    }

    // Mês atual
    function month(){// 11
        $result = new \DateTime();
        return $result->format('m');
    }

    // Dia de hoje
    function day(){// 02
        $result = new \DateTime();
        return $result->format('d');
    }

    // Retorna o dia de amanhã
    function tomorrow(){// 3
        $result = new \DateTime();
        return $result->format('d')+1;
    }

    // Retorna o dia de ontem
    function yesterday(){// 1
        $result = new \DateTime();
        return $result->format('d')-1;
    }

    // Hora atual
    function hour(){// 19
        $result = new \DateTime();
        return $result->format('H');
    }

    // Minutos atuais
    function minute(){// 21
        $result = new \DateTime();
        return $result->format('i');
    }

    // Segundos atuais
    function second(){// 13
        $result = new \DateTime();
        return $result->format('s');
    }

