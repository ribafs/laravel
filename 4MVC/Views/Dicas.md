# Algumas dicas

## Valor default em campos de forms: old 'nome')

{{ old('field_name') ?? $model->field_name ?? 'default' }}

old('value', $model->value ?? $defaultValue)

old('Mobile', $user['Mobile'])

<input type="email" name="email" value="{{ old('email') }}"><br/>


## É bom seguir um padrão de nomes
- Criar o layout com: resources/views/layputs/app.blade.php ou resources/views/templates/master.blade.php

## Boa prática
- Ter um arquivo css com nosso código customizado e de sobrescrição do BS

