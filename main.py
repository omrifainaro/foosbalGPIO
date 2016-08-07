import RPI.GPIO as GPIO
import time
import urlib2
import threading
  
sensetivity = 3  
server_url = ""

class Player(threading.Thread):
    global sensetivity, server_url
    def __init__(self, ir_pin, player_id):
        threading.Thread.__init__(self)
        self.goals = 0
        self.player_id = player_id
        self.ir_pin = ir_pin
    def get_pin(self):
        return self.ir_pin
    def run(self):
        while True:
            val = 0
            for i in range(10):
                val += GPIO.input(self.ir_pin)
            val = val/10
            if val >= sensetivity:
                self.goals += 1
                #send server a goal for player1 and wait for server response
                params = "?player={}&goals={}".format(self.player_id, self.goals)
                response = urllib2.urlopen(server_url + params)
                if "ok" in response.read():
                    print "ok"
                time.sleep(1)

def init():
    player1 = Player(15, "1")
    player2 = Player(18, "2")
    
    GPIO.setup(player1.get_pin, GPIO.IN)
    GPIO.setup(player2.get_pin, GPIO.IN)
    
    player1.start()
    player2.start()
    
    
init()

GPIO.cleanup()    