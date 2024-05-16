package config

import (
	"fmt"

	culqi "github.com/culqi/culqi-go"
)

const (
	Publickey     = "INSERTE_SU_LLAVE_PUBLICA"
	Secretkey     = "INSERTE_SU_LLAVE_PRIVADA"
	rsaID         = "a"
	rsaPublicKey  = "a"
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
