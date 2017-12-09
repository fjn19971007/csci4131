import socket
from threading import Thread
from argparse import ArgumentParser

BUFSIZE = 4096


class Server:
    def __init__(self, host, port):
        print("Connecting to port {}".format(port))
        self.host = host
        self.port = port

        self.setup_socket()
        self.accept()


        self.sock.shutdown()
        self.sock.close()

    def setup_socket(self):
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.bind((self.host, self.port))
        self.sock.listen(128)
        print("Waiting for connection...")

    def accept(self):
        while True:
            (client, address) = self.sock.accept()
            th = Thread(target=client_talk, args=(client, address))
            th.start()

def client_talk(client_sock, client_addr):
    print("Receiving message from client...")
    data = client_sock.recv(BUFSIZE)
    while data:
        print(data.decode('utf-8'))
        request = bytes.decode(data)
        checkRequest(client_sock, request)
        data = client_sock.recv(BUFSIZE)

    client_sock.shutdown(1)
    client_sock.close()
    print("Connection closed.")

def checkRequest(sock, request):
    print("Check Request")
    lines = request.split('\n')
    firstLine = lines[0].split(' ')
    method = firstLine[0]
    resource = firstLine[1].replace("/","")
    version = firstLine[2]

    if len(firstLine) != 3:
        file_handler = open("400.html", "r")
        output = file_handler.read()

        sock.send("HTTP/1.1 400 Bad Request\n" +
        "Content-Type: text/html\n" +
        "\n" +
        output)


    elif method != "GET" and method != "POST" and method != "HEAD":
        file_handler = open("405.html", "r")
        output = file_handler.read()

        sock.send("HTTP/1.1 405 Method Not Allowed\n" +
                "Content-Type: text/html\n" +
                "\n" +
        output)


    elif resource == "private.html":
        file_handler = open("403.html", "r")
        output = file_handler.read()
        sock.send("HTTP/1.1 403 Forbidden\n" +
                "Content-Type: text/html\n" +
                "\n" +
                output)


    elif method == "GET":
        if resource == "csumn":
            sock.send("HTTP/1.1 301 Moved Permanently\n" +
            "Location: https://www.cs.umn.edu\n" +
            "\n")

        else:
            try:
                file_handler = open(resource, "r")
                output = file_handler.read()
                sock.send("HTTP/1.1 200 OK\n" +
                "Content-Type: text/html\n" +
                "\n" +
                output)

            except Exception:
                print("Cannot read file")
                file_handler = open("404.html", "r")
                output = file_handler.read()
                sock.send("HTTP/1.1 404 Not Found\n" +
                "Content-Type: text/html\n" +
                "\n" +
                output)

    elif method == "HEAD":
        try:
            file_handler = open(resource, "r")
            output = file_handler.read()
            sock.send("HTTP/1.1 200 OK\n" +
            "Content-Type: text/html\n" +
            "\n")

        except Exception:
            print("Cannot read file")
            file_handler = open("404.html", "r")
            output = file_handler.read()
            sock.send("HTTP/1.1 404 Not Found\n" +
            "Content-Type: text/html\n" +
            "\n")

    elif method == "POST":
            form = request.split("\n")
            form = form[-1]
            mylist = form.split("&")
            eventName = mylist[0].split("=")
            starttime = mylist[1].split("=")
            endtime = mylist[2].split("=")
            location = mylist[3].split("=")
            day = mylist[4].split("=")

            sock.send("HTTP/1.1 200 OK\n" +
            "Content-Type: text/html\n" +
            "\n" +
            "<html>\n" +
                "<head>\n" +
                    "<title>Submit</title>\n" +
                "</head>\n" +
                "<body>\n" +
                    "<table>\n" +
                        "<caption>Form Data Successfully Submitted</caption>" +
                        "<tr>" +
                        "<th>Event Name: </th>" +
                        "<td>" + eventName[1].replace("+"," ") + "</td>\n" + "</tr>" +
                        "<tr>" +
                        "<th>Start Time: </th>" +
                        "<td>" + starttime[1].replace("%3A",":") + "</td>\n" + "</tr>" +
                        "<tr>" +
                        "<th>End Time: </th>" +
                        "<td>" + endtime[1].replace("%3A",":") + "</td>\n" + "</tr>" +
                        "<tr>" +
                        "<th>Location: </th>" +
                        "<td>" + location[1].replace("+"," ") + "</td>\n" + "</tr>" +
                        "<tr>" +
                        "<th>Day: </th>" +
                        "<td>" + day[1] + "</td>\n" + "</tr>" +
                    "</table>\n" +
                "</body>\n" +
            "</html>")


    else:
        file_handler = open("406.html", "r")
        output = file_handler.read()
        sock.send("HTTP/1.1 406 Not Acceptable\n" +
            "Content-Type: text/html\n" +
            "\n" +
            output)
    print("Message Sent")




def parse_args():
    parser = ArgumentParser()
    parser.add_argument('--host', type=str, default='localhost', help='specify a host to operate on (default: localhost)')
    parser.add_argument('-p', '--port', type=int, default=9001, help='specify a port to operate on (default: 9001)')
    args = parser.parse_args()
    return (args.host, args.port)

if __name__ == '__main__':
    (host, port) = parse_args()
    Server(host, port)
