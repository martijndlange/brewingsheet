<template>
  <div class="container">
    <div class="columns is-gapless">
      <div class="column">
        <div class="panel is-primary">
          <p class="panel-heading">
            Kas: {{ saldo }}
          </p>
          <!-- styling tabs: https://jsfiddle.net/sol_b/L3wLe6h0/2/ -->
          <!-- styling tabs: https://codepen.io/puerdon/pen/RVeZjP -->

          <div class="content-container">
            <tabs
              classString="is-centered is-boxed is-medium is-fullwidth"
            >
              <tab
                name="Mutaties"
                :selected="true">
                <tabs>
                  <tab name="Overzicht" :selected="true">
                    <div class="table-holder">
                      <table class="table is-fullwidth">
                        <tr v-for="(row, rindex) in mutations">
                          <td
                            v-for="(col, cindex) in parsedRow(row)"
                            :style="cindex === 3 ? 'color: green;' : cindex === 4 ? 'color: red;' : ''"
                          >
                            {{ cindex === 1 ? col.charAt(0).toUpperCase() : col }}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </tab>
                  <tab name="Maken">
                    <form action="/mutation" method="post">
                      <div class="form-holder">
                        <div class="field">
                          <label class="label">Naam</label>
                          <div class="control buttons">
                            <div>
                              <input type="radio" id="radio-mutation-name-1" name="name" value="Henk" checked>
                              <label for="radio-mutation-name-1">H</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-mutation-name-2" name="name"value="Emiel">
                              <label for="radio-mutation-name-2">E</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-mutation-name-3" name="name" value="Rick">
                              <label for="radio-mutation-name-3">R</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-mutation-name-4" name="name" value="Martijn">
                              <label for="radio-mutation-name-4">M</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-mutation-name-5" name="name" value="Gerard">
                              <label for="radio-mutation-name-5">S</label>
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label class="label">Datum</label>
                          <input class="input" name="date" type="date">
                        </div>
                        <div class="field">
                          <label class="label">Omschrijving</label>
                          <div class="control">
                            <div v-if="!choiceMade" class="select is-fullwidth">
                              <select
                                name="description"
                                v-model="description"
                                @change="choiceMade = true"
                              >
                                <option
                                  value="Selecteer..."
                                  :selected="true"
                                >Selecteer...</option>
                                <optgroup label="Omschrijving">
                                  <option
                                    :value="`Brouwmaterialen ${getLastMonth()}`"
                                  >{{ `Brouwmaterialen ${getLastMonth()}` }}
                                  </option>
                                  <option
                                    :value="`Brouwmaterialen ${getNextMonth()}`"
                                  >{{ `Brouwmaterialen ${getNextMonth()}` }}
                                  </option>
                                  <option
                                    :value="`Eten brouwdag ${getLastMonth()}`"
                                  >{{ `Eten brouwdag ${getLastMonth()}` }}
                                  </option>
                                  <option
                                    :value="`Eten brouwdag ${getNextMonth()}`"
                                  >{{ `Eten brouwdag ${getNextMonth()}` }}
                                  </option>
                                  <option
                                    :value="`Kosten brouwdag ${getLastMonth()}`"
                                  >{{ `Kosten brouwdag ${getLastMonth()}` }}
                                  </option>
                                  <option
                                    :value="`Kosten brouwdag ${getNextMonth()}`"
                                  >{{ `Kosten brouwdag ${getNextMonth()}` }}
                                  </option>
                                  <option
                                    value="Proevertjes"
                                  >Proevertjes
                                  </option>
                                  <option
                                    value="Diversen - "
                                  >Diversen
                                  </option>
                                </optgroup>
                              </select>
                            </div>
                            <div v-else>
                              <input
                                class="input"
                                name="description"
                                type="text"
                                v-model="description">
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label class="label">Af / Bij</label>
                          <div class="control buttons">
                            <div>
                              <input type="radio" id="radio-mutation-type-1" name="type" value="af" checked>
                              <label for="radio-mutation-type-1">Afboeken</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-mutation-type-2" name="type"value="bij">
                              <label for="radio-mutation-type-2">Bijboeken</label>
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label class="label">Bedrag</label>
                          <div class="control">
                            <input class="input" type="number" name="amount">
                            <span class="icon is-small is-left">
                        <i class="fas fa-globe"></i>
                      </span>
                          </div>
                        </div>
                      </div>
                      <div class="panel-block">
                        <div class="control">
                          <button
                            class="button is-link is-fullwidth"
                            @click="buttonMutationClicked = true"
                            :class="{'is-loading': buttonMutationClicked}"
                          >
                            Versturen
                          </button>
                        </div>
                      </div>
                    </form>
                  </tab>
                </tabs>
              </tab>

              <tab name="Inleg">
                <tabs>
                  <tab name="Overzicht" :selected="true">
                    <div class="table-holder">
                      <table class="table is-fullwidth">
                        <tr v-for="(row, rindex) in dataFields">
                          <td
                            v-for="(col, cindex) in parsedRow(row)"
                            :class="{
                          'col--month': cindex === 0,
                          'row--name': rindex === 0,
                          'row--total': rindex === 1
                         }"
                          >
                            {{ getCellValue(col) }}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </tab>
                  <tab name="Storten">
                    <form action="/contribution" method="post">
                      <div class="form-holder">
                        <div class="field">
                          <label class="label">Naam</label>
                          <div class="control buttons">
                            <div>
                              <input type="radio" id="radio-deposit-name-1" name="name" value="Henk" checked>
                              <label for="radio-deposit-name-1">H</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-deposit-name-2" name="name"value="Emiel">
                              <label for="radio-deposit-name-2">E</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-deposit-name-3" name="name" value="Rick">
                              <label for="radio-deposit-name-3">R</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-deposit-name-4" name="name" value="Martijn">
                              <label for="radio-deposit-name-4">M</label>
                            </div>
                            <div>
                              <input type="radio" id="radio-deposit-name-5" name="name" value="Gerard">
                              <label for="radio-deposit-name-5">S</label>
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label class="label">Maand</label>
                          <div class="control">
                            <div class="select is-fullwidth">
                              <select name="month">
                                <option
                                  v-for="(month, index) in months"
                                  :value="month"
                                  :selected="isCurrentMonth(index)"
                                >{{ month.charAt(0).toUpperCase() + month.slice(1) }}
                                </option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label class="label">Bedrag</label>
                          <div class="control">
                            <div class="select is-fullwidth">
                              <select name="amount">
                                <option value="10">€ 10,00</option>
                                <option value="0">€ 0,00</option>
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
                          <button
                            class="button is-link is-fullwidth"
                            @click="buttonContributionClicked = true"
                            :class="{'is-loading': buttonContributionClicked}"
                          >
                            Versturen
                          </button>
                        </div>
                      </div>
                    </form>
                  </tab>
                </tabs>
              </tab>

            </tabs>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  import bulmaCalendar from 'bulma-calendar';

  export default {
    props: {
      saldo: {
        type: String,
        required: false,
        default: 'sdf',
      },
      dataFields: {
        type: Array,
        required: false,
        default: () => []
      },
      mutations: {
        type: Array,
        required: false,
        default: () => []
      },
    },
    data() {
      return{
        months: [
          'januari',
          'februari',
          'maart',
          'april',
          'mei',
          'juni',
          'juli',
          'augustus',
          'september',
          'oktober',
          'november',
          'december',
        ],
        date: new Date(),
        choiceMade: false,
        buttonMutationClicked: false,
        buttonContributionClicked: false,
        description: 'Selecteer...',
      };
    } ,
    mounted() {
      const calendar = bulmaCalendar.attach(this.$refs.calendarTrigger, {
        startDate: this.date,
        dateFormat: 'DD/MM',
        displayMode: 'dialog',
        showClearButton: false,
        todayLabel: 'Vandaag',
        color: 'info',
      })[0]
      calendar.on('date:selected', e => (this.date = e.start || null))
    },
    computed: {
      maxCols() {
        let max = 0;
        this.dataFields.forEach((row) => max = max < row.length ? row.length : max);
        return max;
      },
    },
    methods: {
      getToday() {
        const d = new Date();
        return d.getDate();
      },
      getLastMonth() {
        const d = new Date();
        return this.months[d.getMonth()];
      },
      getNextMonth() {
        const d = new Date();
        return this.months[d.getMonth()+1];
      },
      parsedRow(row) {
        let ret = new Array(this.maxCols);
        row.forEach((row, i) => ret[i] = row);
        return ret;
      },
      getCellValue: function(val) {
        return val !== undefined ? val.split(',')[0] : '';
      },
      isCurrentMonth: function(index) {
        const d = new Date();
        return d.getMonth() === index;
      },
      switchTab: function (tab) {
        //$('#tabs li').removeClass('is-active');
        //tab.addClass('is-active');
        //$('#tab-content p').removeClass('is-active');
       // $('p[data-content="' + tab + '"]').addClass('is-active');
      }
    }
  }

</script>
<style lang="scss">

  .buttons {
    display: flex;
    flex-direction: row;
    align-items: stretch;
    width: 100%;
    padding-bottom: 10px;

    > div {
        flex: 1;
    }
  }

.content-container {
  padding-top: 10px;
}

.table-holder {
  padding: 0 0 40px 0;
}

td {
  font-size: 10px;

  &.row {
    &--name {
      font-weight: bold;
    }
    &--total {
      background-color: #eee;
      font-weight: bold;
    }
  }
  &.col {
    &--month {
      font-weight: bold;
    }
  }
}

/*
Hide radio button (the round disc)
we will use just the label to create pushbutton effect
*/
input[type=radio] {
  display:none;
  margin:10px;
}

/*
  Change the look'n'feel of labels (which are adjacent to radiobuttons).
  Add some margin, padding to label
*/
input[type=radio] + label {
  width: 100%;
  display:inline-block;
  margin:-2px;
  padding: 6px 12px;
  background-color: #e7e7e7;
  border-color: #ddd;
}
/*
 Change background color for label next to checked radio button
 to make it look like highlighted button
*/
input[type=radio]:checked + label {
  background-image: none;
  background-color:#d0d0d0;
}
input[type=radio] {
  display:none;
}

input[type=radio] + label {
  display:inline-block;
  margin:-2px;
  padding: 8px 12px;
  margin-bottom: 0;
  font-size: 14px;
  line-height: 20px;
  color: #333;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255,255,255,0.75);
  vertical-align: middle;
  cursor: pointer;
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
  background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
  background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
  background-image: -o-linear-gradient(top,#fff,#e6e6e6);
  background-image: linear-gradient(to bottom,#fff,#e6e6e6);
  background-repeat: repeat-x;
  border: 1px solid #ccc;
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
  border-bottom-color: #b3b3b3;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
  box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
}

input[type=radio]:checked + label {
  background-image: none;
  outline: 0;
  -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
  -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
  background-color:#e0e0e0;
}
</style>
