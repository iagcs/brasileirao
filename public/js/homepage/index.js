let home_teams = [];
let guest_teams = [];
const selectTimeVisitante = $("#select_time_visitante");
const selectTimeCasa = $("#select_time_casa");
const golsTimeVisitante = $("#gols_time_visitante");
const golsTimeCasa = $("#gols_time_casa");
const championshipTableTBody = $("#championship-table tbody");

toastr.options = {
    "closeButton" : true,
    "progressBar" : true
}

const createMatch = () => {

    const time_casa_id = selectTimeCasa.val();
    const gols_time_casa = golsTimeCasa.val();

    const time_visitante_id = selectTimeVisitante.val();
    const gols_time_visitante = golsTimeVisitante.val();


    const csrf = $('input[name="_token"]').val();

    const data = {
        "time_casa_id": time_casa_id,
        "gols_em_casa": gols_time_casa,
        "time_visitante_id": time_visitante_id,
        "gols_visitante": gols_time_visitante
    };
    for (let i in data) {
        if(!data[i]) {
            toastr.warning("Todos os campos são obrigatórios");
            return;
        }
    }

    $.ajax({
        url: 'matches',
        type: 'POST',
        dataType: 'json',
        data: data,
        headers: {
            "X-CSRF-TOKEN": csrf
        },
        success: () => {
            toastr.success("Confronto inserido com sucesso");
        },
        error: (err) => {
            const errors = JSON.parse(err.responseText);
            const message = (errors.message).toString();
            console.log(message.toString());
            if(errors) {
                toastr.error(message);
            }
        }
    });

    const closeBtn = $("#insert-modal .btn-close");
    closeBtn.click();

    golsTimeVisitante.val("");
    golsTimeCasa.val("");

    getTeamsForSelect();
    getTableTeams();
}

const onlyNumbers = (item) => item.value = item.value.replace(/[^0-9]/g, '');

const textColorToTable = (index) => {

    if (index === 1) {
        return 'bi bi-caret-right-fill text-success';
    } else if (index >= 2 && index <= 7) {
        return 'bi bi-caret-right-fill text-primary';
    } else if (index >= 8 && index <= 14) {
        return 'bi bi-caret-right-fill text';
    } else if(index >= 17) {
        return 'bi bi-caret-right-fill text-danger';
    } else {
        return 'bi bi-caret-right-fill text-warning';
    }

}

const getTableTeams = () => {
    $.ajax({
        url: 'teams/results',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            console.log(res);
            const teams = res.teams.map((team, index) =>`
                    <tr>
                    <td><span class="${textColorToTable(index+1)}"></span></td>
                    <td>${index + 1}º ${team.nome}</td>
                    <td><strong>${team.pontos}</strong></td>
                    <td class="text-secondary">${team.jogos}</td>
                    <td class="text-secondary">${team.vitorias}</td>
                    <td class="text-secondary">${team.empates}</td>
                    <td class="text-secondary">${team.derrotas}</td>
                    <td class="text-secondary">${team.gols_pro}</td>
                    <td class="text-secondary">${team.gols_contra}</td>
                    <td class="text-secondary">${team.saldo_gols}</td>
                    </tr>
                `);
            championshipTableTBody.html(teams);
        }
    });
}
getTableTeams();

const getTeamsForSelect = () => {
    $.ajax({
        url: 'teams',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            const teams = res.teams.map(({ name, id }) => `<option value="${id}">${name}</option>`);

            home_teams = res.teams;
            guest_teams = res.teams;

            const _selectTimeCasa = [ `<option selected>Time da casa</option>`, ...teams ];
            const _selectTimeVisitante = [ `<option selected>Visitante</option>`, ...teams ];

            selectTimeCasa.html(_selectTimeCasa);
            selectTimeVisitante.html(_selectTimeVisitante);
        }
    });
}

getTeamsForSelect();