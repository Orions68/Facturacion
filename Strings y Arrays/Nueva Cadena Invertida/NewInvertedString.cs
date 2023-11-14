namespace Nueva_Cadena_Invertida
{
    internal class NewInvertedString
    {
        static void Main(string[] args)
        {
            string word;
            string word2 = "";
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Invierte la palabra que Ingresas por Teclado y la Asigna a una Nueva Variable.\n");
                Console.Write("Por Favor Ingresa una Palabra: ");
                word = Console.ReadLine();
                Console.WriteLine();
                for (int i = word.Length - 1; i >= 0; i--)
                {
                    word2 += word[i];
                }
                Console.WriteLine();
                Console.WriteLine("La Cadena Resultante es: {0}\n", word2);
                Console.WriteLine();
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                word2 = "";
                Console.Clear();
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}