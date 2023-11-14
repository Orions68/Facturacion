namespace Inversor_de_Cadena
{
    internal class InvertString
    {
        static void Main(string[] args)
        {
            string word;
            char seguir = 's';

            while (seguir == 's')
            { 
                Console.WriteLine("Este Programa Invierte la palabra que Ingresas por Teclado.\n");
                Console.Write("Por Favor Ingresa una Palabra: ");
                word = Console.ReadLine();
                Console.WriteLine();
                for (int i = word.Length - 1; i >= 0; i--)
                {
                    Console.Write(word[i]);
                }
                Console.WriteLine();
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                Console.Clear();
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}