package config

import (
	"fmt"

	culqi "github.com/culqi/culqi-go"
)

const (
	Publickey     = "pk_test_e94078b9b248675d"
	Secretkey     = "sk_test_c2267b5b262745f0"
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
