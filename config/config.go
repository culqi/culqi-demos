package config

import (
	"fmt"

	culqi "github.com/culqi/culqi-go"
)

const (
	Publickey     = "<<LLAVE PÚBLICA>>"
	Secretkey     = "<<LLAVE SECRETA>>"
	rsaID         = "<<LLAVE PÚBLICA RSA ID>>"
	rsaPublicKey  = "<<LLAVE PÚBLICA RSA>>"
	Port          = ":3000"
	Encrypt       = "0"
	encryptionFmt = `{
		"rsa_public_key": "%s",
		"rsa_id":  "%s"
	}`
)

var (
	EncryptionData []byte
)

func init() {
	culqi.Key(Publickey, Secretkey)

	EncryptionData = []byte(fmt.Sprintf(encryptionFmt, rsaPublicKey, rsaID))
}
