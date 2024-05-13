from flask import Flask, request, render_template, json
from flask_restful import Api
from flask_cors import CORS

from culqi import __version__
from culqi.client import Culqi
from culqi.resources import Card, Order, Customer, Charge

app = Flask(__name__, template_folder="src/templates")
api = Api(app)
CORS(app)

public_key = "<<LLAVE PÚBLICA>>"
private_key = "<<LLAVE PRIVADA>>"
rsa_id = "<<RSA ID>>"
rsa_public_key = ("<<LLAVE PúBLICA RSA>>")
port = 5100

def create_response(data, status):
    return app.response_class(
        response=json.dumps(data),
        status=json.dumps(status),
        mimetype="application/json",
    )


@app.route("/", methods=["GET", "POST"])
def home():
    print("Culqi Version: ", __version__)
    return render_template("index.html")


@app.route("/culqi/createCard", methods=["POST"])
def generate_card():
    body = request.json
    culqi = Culqi(public_key, private_key)
    card = Card(client=culqi)
    card = card.create(body)
    return create_response(card["data"], card["status"])


@app.route("/culqi/createCustomer", methods=["POST"])
def generate_customer():
    body = request.json
    culqi = Culqi(public_key, private_key)
    customer = Customer(client=culqi)
    data = {
        "first_name": body["first_name"],
        "last_name": body["last_name"],
        "email": body["email"],
        "address": body["address"],
        "address_city": body["address_city"],
        "country_code": body["country_code"],
        "phone_number": body["phone_number"],
    }
    card = customer.create(data)
    return create_response(card["data"], card["status"])


@app.route("/culqi/generateCharge", methods=["POST"])
def generate_charge():
    body = request.json
    culqi = Culqi(public_key, private_key)
    charge = Charge(client=culqi)
    options = {}
    if rsa_public_key is not None:
        options["rsa_public_key"] = rsa_public_key
    if rsa_public_key is not None:
        options["rsa_id"] = rsa_id
    if len(rsa_id) == 0:
        card = charge.create(body)
    else:
        card = charge.create(body, **options)
    return create_response(card["data"], card["status"])


@app.route("/culqi/generateOrder", methods=["POST"])
def generate_order():
    body = request.json
    culqi = Culqi(public_key, private_key)
    order = Order(client=culqi)
    card = order.create(body)
    return create_response(card["data"], card["status"])


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=port)
