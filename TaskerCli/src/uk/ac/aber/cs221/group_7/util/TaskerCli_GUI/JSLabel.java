package uk.ac.aber.cs221.group_7.util.TaskerCli_GUI;
import java.awt.Font;
import javax.swing.JLabel;


/**
 * A specialised JLabel that allows you to specify its font, font style and font size in the constructor
 * @author Group 07: kuh1@aber.ac.uk
 */
public class JSLabel extends JLabel{
	
	/**
	 * Creates a new label with the specified font
	 * @param text
	 * 			The text that label will show
	 * @param fontName
	 * 			The font the label will use
	 * @param fontStyle
	 * 			The style parameter of the font, e.g. Font.BOLD
	 * @param fontSize
	 * 			The size of the font
	 */
	public JSLabel(String text, String fontName, int fontStyle, int fontSize){
		super(text);
		
		setFont(new Font(fontName, fontStyle, fontSize));
	}
	
	JSLabel(){
		super();
	}
}
