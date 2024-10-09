import { checkoutConfig } from "../js/config/index.js";
import { deletCard } from "../js/eliminarCard.js";

getListCards();
function formatDate(unixTimeStamp) {
  const date = moment.tz(unixTimeStamp, "America/New_York");
  return date.local().format("DD/MM/YYYY HH:mm:ss");
}

function resultdiv2(message) {
  $("#response-panel2").show();
  $("#response2").html(message);
}

function showTable(cardList, idRecent = null) {
  $(".table.table-hover").remove();
  setTimeout(() => {
    const table = $("<table></table>").addClass("table table-hover");
    const thead = $("<thead></thead>");
    const tbody = $("<tbody></tbody>").addClass("tbodyContainer");
    thead.append(
      $("<tr></tr>").append(
        $("<th></th>").text("ID"),
        $("<th></th>").text("Creation date")
      )
    );

    table.append(thead);
    cardList.forEach((card) => {
      let row = $("<tr></tr>").addClass(idRecent === card.id ? "success" : "");
      row.append($("<td></td>").text(card.id));
      row.append($("<td></td>").text(formatDate(card.creation_date)));
      row.append(
        $("<td></td>").append(
          $("<button></button>")
            .addClass("btn btn-primary")
            .text("Usar")

            .on("click", function () {
              // Copiar directamente el ID de la tarjeta al portapapeles
              navigator.clipboard.writeText(card.id).then(
                function() {
                  alert("ID de tarjeta copiado al portapapeles: " + card.id);
                },
                function(err) {
                  alert("Error al copiar al portapapeles: ", err);
                }
              )

            })
        )
      );
      row.append(
        $("<td></td>").append(
          $("<button></button>")
            .addClass("btn btn-danger")
            .text("Eliminar")

            .on("click", function () {
              deletCard(card.id);
              if ($("#idCard1").val() == card.id) {
                $("#idCard1").val("");
              }
            })
        )
      );

      tbody.append(row);
    });
    table.append(tbody);

    if ($("table").length) {
      $("#table-card-container tr:first").after(row);//
    } else {
      $("#table-card-container").append(table);//
    }
  }, 1000);
}

export function getListCards(idRecent = null) {
  $.ajax({
    type: "GET",
    url: `${checkoutConfig.URL_BASE}`+"/ajax/getlistCard.php",
    datatype: "json",
    success: function (data) {
      var cardList = "";
      if (data.data) {
        cardList = data.data;
      }
      showTable(cardList, idRecent);
    },
    error: function (error) {
      resultdiv2(error);
    },
  });
}

$("#listarCard").on("click", function (e) {
  getListCards();
  e.preventDefault();
});
