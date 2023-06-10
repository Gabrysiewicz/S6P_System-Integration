using ServiceReference1;
using System.Text;

namespace SoapClient
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            GetNameAsync(idTextBox.Text);
        }

        private async Task GetNameAsync(string id)
        {
            GameServicePortTypeClient client = new GameServicePortTypeClient();
            GetGameNameResponse response = await client.GetGameNameAsync(id);
            if (response.result == null)
            {
                wynikLabel.Text = "Nazwa gry: Brak gry o podanym id";
            }
            else
            {
                wynikLabel.Text = $"Nazwa gry: {response.result}";
            }
        }
    }
}