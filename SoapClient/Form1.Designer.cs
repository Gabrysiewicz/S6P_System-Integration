namespace SoapClient
{
    partial class Form1
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            pobierzLabel = new Label();
            idTextBox = new TextBox();
            idLabel = new Label();
            pobierzButton = new Button();
            wynikLabel = new Label();
            SuspendLayout();
            // 
            // pobierzLabel
            // 
            pobierzLabel.Location = new Point(12, 9);
            pobierzLabel.Name = "pobierzLabel";
            pobierzLabel.Size = new Size(358, 16);
            pobierzLabel.TabIndex = 0;
            pobierzLabel.Text = "Pobierz nazwę gry";
            pobierzLabel.TextAlign = ContentAlignment.MiddleCenter;
            // 
            // idTextBox
            // 
            idTextBox.Location = new Point(12, 52);
            idTextBox.Name = "idTextBox";
            idTextBox.Size = new Size(358, 23);
            idTextBox.TabIndex = 1;
            // 
            // idLabel
            // 
            idLabel.AutoSize = true;
            idLabel.Location = new Point(12, 34);
            idLabel.Name = "idLabel";
            idLabel.Size = new Size(51, 15);
            idLabel.TabIndex = 2;
            idLabel.Text = "Podaj ID";
            // 
            // pobierzButton
            // 
            pobierzButton.Location = new Point(12, 81);
            pobierzButton.Name = "pobierzButton";
            pobierzButton.RightToLeft = RightToLeft.No;
            pobierzButton.Size = new Size(358, 23);
            pobierzButton.TabIndex = 3;
            pobierzButton.Text = "Pobierz";
            pobierzButton.UseVisualStyleBackColor = true;
            pobierzButton.Click += button1_Click;
            // 
            // wynikLabel
            // 
            wynikLabel.AutoSize = true;
            wynikLabel.Location = new Point(12, 118);
            wynikLabel.Name = "wynikLabel";
            wynikLabel.Size = new Size(68, 15);
            wynikLabel.TabIndex = 4;
            wynikLabel.Text = "Nazwa gry: ";
            // 
            // Form1
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(382, 148);
            Controls.Add(wynikLabel);
            Controls.Add(pobierzButton);
            Controls.Add(idLabel);
            Controls.Add(idTextBox);
            Controls.Add(pobierzLabel);
            FormBorderStyle = FormBorderStyle.FixedSingle;
            MinimizeBox = false;
            Name = "Form1";
            Text = "SOAP Client";
            Load += Form1_Load;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label pobierzLabel;
        private TextBox idTextBox;
        private Label idLabel;
        private Button pobierzButton;
        private Label wynikLabel;
    }
}