package main

import (
	"fmt"
	"io"
	"log"
	"mime"
	"net/http"
	"os"

	"path/filepath"
	"text/template"

	"github.com/culqi/culqi-go"
	"github.com/go-chi/chi"
	"github.com/rs/cors"

	config "culqi-go-demo/config"
)

func main() {
	r := chi.NewRouter()
	mime.AddExtensionType(".js", "application/javascript; charset=utf-8")

	r.Get("/*", handleRequest)
	r.Get("/", homePageHandler)
	r.Post("/culqi/generateCard", cardsPageHandler)
	r.Post("/culqi/generateCustomer", customerPageHandler)
	r.Post("/culqi/generateCharge", chargePageHandler)
	r.Post("/culqi/generateOrder", orderPageHandler)

	c := cors.New(cors.Options{
		AllowedOrigins:   []string{"*"},
		AllowCredentials: true,
		AllowedMethods:   []string{"GET", "DELETE", "POST", "PUT"},
	})

	handler := c.Handler(r)
	log.Fatal(http.ListenAndServe(config.Port, handler))
}

func handleRequest(w http.ResponseWriter, r *http.Request) {
	workDir, _ := os.Getwd()
	filesDir := filepath.Join(workDir, "src/js")
	http.ServeFile(w, r, filesDir+r.URL.Path)
}

func homePageHandler(w http.ResponseWriter, r *http.Request) {
	serveTemplate(w, "index.html", "sidebar.html", "mode/with-create-card.html", "mode/only-card.html")
}

func serveTemplate(w http.ResponseWriter, filenames ...string) {
	var templates []string
	for _, filename := range filenames {
		path := filepath.Join("src/templates", filename)
		templates = append(templates, path)
	}
	tmpl, err := template.ParseFiles(templates...)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	err = tmpl.Execute(w, nil)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
	}
}

// Consumo de servicios
func cardsPageHandler(w http.ResponseWriter, r *http.Request) {
	reqBody, _ := io.ReadAll(r.Body)

	if config.Encrypt == "1" {
		statusCode, res, _ := culqi.CreateCard(reqBody, config.EncryptionData...)
		fmt.Println(statusCode)
		fmt.Println(res)
		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(statusCode)
		w.Write([]byte(res))
	} else {
		statusCode, res, _ := culqi.CreateCard(reqBody)
		fmt.Println("Resultados")
		fmt.Println(statusCode)
		fmt.Println(res)
		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(statusCode)
		w.Write([]byte(res))
	}
}

func chargePageHandler(w http.ResponseWriter, r *http.Request) {
	reqBody, _ := io.ReadAll(r.Body)
	log.Printf("error decoding sakura response: %v", reqBody)

	if config.Encrypt == "1" {
		statusCode, res, _ := culqi.CreateCharge(reqBody, config.EncryptionData...)
		fmt.Println(statusCode)
		fmt.Println(res)
		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(statusCode)
		w.Write([]byte(res))
	} else {
		statusCode, res, _ := culqi.CreateCharge(reqBody)
		fmt.Println("Resultados")
		fmt.Println(statusCode)
		fmt.Println(res)
		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(statusCode)
		w.Write([]byte(res))
	}

}

func customerPageHandler(w http.ResponseWriter, r *http.Request) {
	fmt.Println(r.Body)
	reqBody, err := io.ReadAll(r.Body)
	if err != nil {
		log.Fatal(err)
	}
	bodyString := string(reqBody)
	fmt.Println(bodyString)
	log.Printf("error decoding sakura response: %v", reqBody)

	statusCode, res, err := culqi.CreateCustomer(reqBody)
	fmt.Println(err)
	fmt.Println("statusCode")
	fmt.Println(statusCode)
	fmt.Println(res)

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(statusCode)
	w.Write([]byte(res))
}

func orderPageHandler(w http.ResponseWriter, r *http.Request) {
	fmt.Println(r.Body)
	reqBody, err := io.ReadAll(r.Body)
	if err != nil {
		log.Fatal(err)
	}
	bodyString := string(reqBody)
	fmt.Println(bodyString)
	log.Printf("error decoding sakura response: %v", reqBody)

	statusCode, res, err := culqi.CreateOrder(reqBody, config.EncryptionData...)
	fmt.Println(err)
	fmt.Println("statusCode")
	fmt.Println(statusCode)
	fmt.Println(res)

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(statusCode)
	w.Write([]byte(res))
}
