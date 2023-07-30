#include <Arduino.h>
#include <WiFi.h>
#include <WiFiMulti.h>
#include <HTTPClient.h>
#include <DHT.h>

WiFiMulti wifiMulti;
const char* ssid = "HUNIAN BRUTAL";
const char* password = "KONTRAKANKITA";
const int pin_dht = 26;
const int pin_led_blue = 13;
const int pin_led_green = 12;
const int pin_led_red = 14;
const int pin_fan = 27;
DHT dht(pin_dht, DHT11);

void setup() {
  Serial.begin(115200);
  Serial.println();
  for(uint8_t t = 4; t > 0; t--){
    Serial.printf("[SETUP] WAIT %d... \n", t);
    Serial.flush();
    delay(1000);
  }
  wifiMulti.addAP(ssid, password);
  Serial.print("Wifi Tersambung");
  dht.begin();
  pinMode(pin_led_blue, OUTPUT);
  pinMode(pin_led_green, OUTPUT);
  pinMode(pin_led_red, OUTPUT);
  pinMode(pin_fan, OUTPUT);
}

void loop(){
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  int statusTemperature = 0;
  int statusHumidity = 0;

  if (temperature > 35) {
    statusTemperature = 10;
    digitalWrite(pin_led_red, HIGH);
    digitalWrite(pin_led_green, LOW);
    digitalWrite(pin_led_blue, LOW);
    digitalWrite(pin_fan, HIGH);
  } else if (temperature >= 25 && temperature <= 35) {
    statusTemperature = 5;
    digitalWrite(pin_led_green, HIGH);
    digitalWrite(pin_led_red, LOW);
    digitalWrite(pin_led_blue, LOW);
    digitalWrite(pin_fan, LOW);
  } else {
    statusTemperature = 0;
    digitalWrite(pin_led_blue, HIGH);
    digitalWrite(pin_led_green, LOW);
    digitalWrite(pin_led_red, LOW);
    digitalWrite(pin_fan, LOW);
  }

  if (humidity > 65) {
    statusHumidity = 10;
  } else if (humidity >= 45 && humidity <= 65) {
    statusHumidity = 5;
  } else {
    statusHumidity = 0;
  }

  if((wifiMulti.run() == WL_CONNECTED)) {
    HTTPClient http;
    Serial.print("[HTTP] BEGIN... \n");
    Serial.println(temperature);
    Serial.println(humidity);
    Serial.println(statusTemperature);
    Serial.println(statusHumidity);
    String url = "http://192.168.1.11/web/kirimdata.php?";
    String postData = "temperature=" + String(temperature) +
                      "&humidity=" + String(humidity) +
                      "&status_temperature=" + String(statusTemperature) +
                      "&status_humidity=" + String(statusHumidity);
    Serial.print("URL to send : " + url + "\n");
    Serial.print("Data to send : " + postData + "\n");
    http.begin(url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.POST(postData);

    if(httpCode > 0) {
      Serial.printf("[HTTP] POST.... code : %d\n", httpCode);

      if(httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        Serial.println(payload);
      }
    } else {
      Serial.printf("[HTTP] POST.... failed, error : %s\n", http.errorToString(httpCode).c_str());
    }

    http.end();
  }

  delay(5000);
}
