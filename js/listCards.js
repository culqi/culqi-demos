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
  $(".table-responsive").remove(); // Remover cualquier tabla existente
  setTimeout(() => {
    // Contenedor responsivo para la tabla
    const tableContainer = $("<div></div>").addClass("table-responsive");
    
    const table = $("<table></table>").addClass("table table-hover");
    const thead = $("<thead></thead>");
    const tbody = $("<tbody></tbody>").addClass("tbodyContainer");
    
    thead.append(
      $("<tr></tr>").append(
        $("<th></th>").text("ID"),
        $("<th></th>").text("Creation date"),
        $("<th></th>").text("Actions") // Encabezado para las acciones
      )
    );

    table.append(thead);

    // Limitar el listado a las tres primeras tarjetas
    const limitedCardList = cardList.slice(0, 3);

    limitedCardList.forEach((card) => {
      let row = $("<tr></tr>").addClass(idRecent === card.id ? "success" : "");
      row.append($("<td></td>").text(card.id));
      row.append($("<td></td>").text(formatDate(card.creation_date)));
      
      // Columna para los botones de acción
      const actionCell = $("<td></td>");
      
      // Botón "Usar"
      const useButton = $("<button></button>")
        .addClass("btn btn-primary btn-sm") // Tamaño de botón pequeño
        .text("Usar")
        .on("click", function () {
          // Copiar el ID de la tarjeta al portapapeles
          navigator.clipboard.writeText(card.id).then(
            function() {
              alert("ID de tarjeta copiado al portapapeles: " + card.id);
            },
            function(err) {
              alert("Error al copiar al portapapeles: ", err);
            }
          );
          // Asignar el ID de la tarjeta al input de suscripciones
          $("#idCard").val(card.id);
        });

      // Botón "Eliminar"
      const deleteButton = $("<button></button>")
        .addClass("btn btn-danger btn-sm") // Tamaño de botón pequeño
        .text("Eliminar")
        .on("click", function () {
          deletCard(card.id);
          if ($("#idCard1").val() == card.id) {
            $("#idCard1").val("");
          }
        });

      // Asegurarnos de que ambos botones tengan el mismo tamaño
      useButton.css("width", "65px");
      deleteButton.css("width", "65px");

      // Añadir los botones a la celda de acciones con margen
      actionCell.append(useButton);
      actionCell.append(deleteButton);

      row.append(actionCell); // Agregar la celda de acciones a la fila
      tbody.append(row);
    });

    table.append(tbody);
    tableContainer.append(table); // Añadir la tabla dentro del contenedor responsivo

    if ($("#table-card-container").find(".table-responsive").length) {
      $("#table-card-container .table-responsive").replaceWith(tableContainer);
    } else {
      $("#table-card-container").append(tableContainer);
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
