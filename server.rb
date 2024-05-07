# frozen_string_literal: true

require 'webrick'
require 'culqi-ruby'

$encrypt = '0'
Culqi.public_key = 'pk_test_90667d0a57d45c48'
Culqi.secret_key = 'sk_test_1573b0e8079863ff'

$rsa_key = '508fc232-0a9d-4fc0-a192-364a0b782b8'
$rsa_id = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDYp0451xITpczkBrl5Goxkh7m1
oynj8eDHypIn7HmbyoNJd8cS4OsT850hIDBwYmFuwmxF1YAJS8Cd2nes7fjCHh+7
oNqgNKxM2P2NLaeo4Uz6n9Lu4KKSxTiIT7BHiSryC0+Dic91XLH7ZTzrfryxigsc
+ZNndv0fQLOW2i6OhwIDAQAB
-----END PUBLIC KEY-----"


# Crear una subclase de WEBrick::HTTPServlet::FileHandler
class CustomHandler < WEBrick::HTTPServlet::FileHandler
  def initialize(server, dir)
    super(server, dir)
  end

  def do_GET(request, response)
    if request.path =~ /\/js\/.*\.js$/i
      response['Content-Type'] = 'application/javascript'
    else
      response['Content-Type'] = 'text/html'
    end

    super(request, response)
  end
end


# Crear una subclase de WEBrick::HTTPServlet::AbstractServlet para el controlador adicional
class CustomerController < WEBrick::HTTPServlet::AbstractServlet
  def do_POST(request, response)


    response['Content-Type'] = 'application/json'

    puts request


    params = JSON.parse(request.body)
    customer, statusCode = Culqi::Customer.create(params)
    response.status = statusCode
    response.body = customer

  end
end

class CardController < WEBrick::HTTPServlet::AbstractServlet
  def do_POST(request, response)

    response['Content-Type'] = 'application/json'

    puts request


    params = JSON.parse(request.body)
    if $encrypt == '1'
      card, statusCode = Culqi::Card.create(params, $rsa_key, $rsa_id)
    else
      card, statusCode = Culqi::Card.create(params)
    end

    puts card
    response.body = card
    response.status = statusCode

  end
end

class ChargeController < WEBrick::HTTPServlet::AbstractServlet
  def do_POST(request, response)
    response['Content-Type'] = 'application/json'

    puts request


    params = JSON.parse(request.body)
    if $encrypt == '1'
      charge, statusCode = Culqi::Charge.create(params, $rsa_key, $rsa_id)
    else
      charge, statusCode = Culqi::Charge.create(params)
    end
    puts charge
    response.body = charge
    response.status = statusCode

  end
end

class OrderController < WEBrick::HTTPServlet::AbstractServlet
  def do_POST(request, response)


    response['Content-Type'] = 'application/json'

    puts request


    params = JSON.parse(request.body)
    if $encrypt == '1'
      order, statusCode = Culqi::Order.create(params, $rsa_key, $rsa_id)
    else
      order, statusCode = Culqi::Order.create(params)
    end
    puts order
    response.body = order
    response.status = statusCode

  end
end

# Configurar el servidor
server = WEBrick::HTTPServer.new(Port: 8000)

# Establecer el directorio raíz del servidor
server.mount('/', CustomHandler, './')


server.mount('/createCustomer', CustomerController)
server.mount('/createCard', CardController)
server.mount('/generateCharge', ChargeController)
server.mount('/generateOrder', OrderController)

# Manejar señales de interrupción para detener el servidor correctamente
trap('INT') { server.shutdown }

# Iniciar el servidor
server.start

