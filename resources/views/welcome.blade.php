<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/app.css">
  <title>Kasboek BUK</title>
</head>
<body>
<div class="container">
  <div class="columns is-gapless">
    <div class="column">
      <div class="panel is-primary">
        <p class="panel-heading">
          Kas: {{ $saldo }}
        </p>
        <form action="/" method="post">
          <div class="form-holder">
            <div class="field">
              <label class="label">Naam</label>
              <div class="control">
                <div class="select is-fullwidth">
                  <select name="name">
                    <option value="Emiel">Emiel</option>
                    <option value="Gerard">Gerard</option>
                    <option value="Henk">Henk</option>
                    <option value="Martijn">Martijn</option>
                    <option value="Rick">Rick</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Maand</label>
              <div class="control">
                <div class="select is-fullwidth">
                  <select name="month">
                    <option value="januari">Januari</option>
                    <option value="februari">Februari</option>
                    <option value="maart">Maart</option>
                    <option value="april">April</option>
                    <option value="mei">Mei</option>
                    <option value="juni">Juni</option>
                    <option value="juli">Juli</option>
                    <option value="augustus">Augustus</option>
                    <option value="september">September</option>
                    <option value="oktober">Oktober</option>
                    <option value="november">November</option>
                    <option value="december">December</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Bedrag</label>
              <div class="control">
                <div class="select is-fullwidth">
                  <select name="amount">
                    <option value="0">€ 0,00</option>
                    <option value="10">€ 10,00</option>
                  </select>
                </div>
                <span class="icon is-small is-left">
                  <i class="fas fa-globe"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="panel-block">
            <div class="control">
              <button class="button is-link is-fullwidth">Versturen</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
