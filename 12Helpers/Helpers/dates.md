# Relação de funções do dates.php com exemplo

Lambrando que não usam biblioteca Laravel, mas apenas PHP

#### dateAddDays($date, $interval, $format){
```php
dateAddDays('2019-03-03', '10 days', 'd/m/Y');
```
#### ageYears($dateBirth, $dateNow, $format='%y'){
```php
ageYears('1956-08-03', '2020-11-02');
```
#### year(){ // Ano atual
```php
year()
```
#### month(){// Mês atual
```php
month()
```
#### day(){// Dia de hoje
```php
day()
```
#### tomorrow(){// Dia de amanhã
```php
tomorrow()
```
#### yesterday(){// Retorna o dia de ontem
```php
yesterday()
```
#### hour(){// Hora atual
```php
hour()
```
#### minute(){// Minutos atuais
```php
minute()
```
#### *second(){// Segundos atuais
```php
seconds()
```

