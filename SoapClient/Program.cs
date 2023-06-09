using ServiceReference1;
using System.Text;

namespace SoapClient
{
    internal class Program
    {
        static async Task Main(string[] args)
        {
            Console.OutputEncoding = Encoding.Unicode;
            Console.WriteLine("SOAP Client");
            GameServicePortTypeClient client = new GameServicePortTypeClient();
            string id = "1";
            GetGameNameResponse response = await
            client.GetGameNameAsync(id);
            if(response.result == null)
            {
                Console.WriteLine($"Brak gry o podanym id w bazie danych");
            }
            else
            {
                Console.WriteLine($"ID: {id}");
                Console.WriteLine($"Nazwa: {response.result}");
            }
        }
    }
}